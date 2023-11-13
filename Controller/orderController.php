<?php
session_start();
include("../Model/db.php");
include '../includes/toastr.inc.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

if (isset($_POST['UPDATESHIPPING'])) {
    $id = $_POST['shipping_id'];
    $n = $_POST['fullname'];
    $c = $_POST['contact_number'];
    $a = $_POST['address'];

    updateUser(
        'shipping_info',
        array('id', 'user_id', 'name', 'contact', 'address'),
        array($id, $_SESSION['id'], $n, $c, $a)
    );

    flash("msg", "success", "Updated Shipping Info");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['PLACEORDER'])) {
    // ORDER
    $cartIDs = $_POST['cart_id']; // Possibly multiple carts
    $userID = $_SESSION['id'];
    $productIDs = $_POST['product_id']; // Possibly multiple products
    $subTotal = $_POST['subTotal'];
    $seller_id = $_POST['seller_id'];


    // ORDER DETAILS
    $fullname = $_POST['fullname'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];

    // PAYMENT OPTION 
    $payment_type = $_POST['payment-type'];
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $reference_number = substr(str_shuffle($characters . time() * rand()), 0, 20);
    // Loop through cart items and insert orders
    foreach ($cartIDs as $i => $cartID) {
        
        $order_fields = array('cart_id','reference_order','user_id', 'product_id', 'status', 'seller_id', 'total', 'isAccept', 'isPayed');
        $order_values = array($cartID,$reference_number ,$userID, $productIDs[$i], 'Pending', $seller_id, $subTotal, 'No', 'No');

        $order_details_fields = array('id', 'name', 'contact_number', 'shipping_address');
        $order_details_values = array($fullname, $contact_number, $address);

        // Update Cart
        updateCart(
            'carts',
            array('id', 'isOrder'),
            array($cartID, 'Yes')
        );

        // Insert data into the database
        // Insert in Order Table
        if (addOrder('orders', $order_fields, $order_values, 'order_details', $order_details_fields, $order_details_values)) {
            //For Notification purposes
            $getUser = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
            $getProduct = mysqli_fetch_assoc(getrecord('product_details', 'id', $productIDs[$i]));
            $desc = $getUser['firstname'] . " " . $getUser['lastname'] . " Ordered your product " . $getProduct['product_name'];
            $notif = sendNotif('notification', array('user_id', 'date_send', 'isRead', 'redirect'), array($seller_id, $date, 'No', 'manageOrder.php'));
            $last_id = mysqli_insert_id($conn);
            sendNotif(
                'notification_details',
                array('notification_id', 'title', 'Description'),
                array($last_id, 'Product Order', $desc)
            );
            if($payment_type == 'COD'){
                header("location:../View/myPurchase.php");
            }else{
                header("location:../View/payment.php?reference_order=" . urlencode($reference_number));
            }
        } else {
            echo "Order placement failed!";
        }
    }

} elseif (isset($_POST['CANCELORDER'])) {
    
    $order_id = $_POST['order_id'];
    $order = mysqli_fetch_assoc(getrecord('orders', 'id', $order_id));
    
    if ($order['status'] == 'Pending') {
        $created_at_timestamp = strtotime($order['created_at']);
        $current_timestamp = time();
        $time_difference = $current_timestamp - $created_at_timestamp;
        $time_in_hours = $time_difference / 3600; 
        
        if ($time_in_hours < 24) {
            removeOrder($order_id);
            flash("msg", "success", "Order Cancel");
            header("Location: ../View/myPurchase.php");
            exit();
        } else {
           flash("msg", "error", "Cant Cancel Order over 24 hours");
            header("Location: ../View/myPurchase.php");
            exit();
        }
    } else {
        flash("msg", "error", "Can't Cancel: Order is not in 'Pending' status");
        header("Location: ../View/myPurchase.php");
        exit();
    }
} elseif (isset($_POST['PAY'])) {
    $reference_order = $_POST['reference_order'];
    $total = $_POST['total'];
    $reference_number = $_POST['reference_number'];
    $order_id = $_POST['order_id'];

    $targetDir = "../images/";
    $target_file = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);

    if ($check !== false) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

       
        foreach ($reference_order as $r => $reference) {
            createUser(
                'order_payments',
                array('order_id', 'user_id', 'reference_no', 'receipt_image', 'amount'),
                array($order_id[$r], $_SESSION['id'], $reference_number, $target_file, $total[$r])
            );

            // Update the order to mark it as paid
            updateUser('orders', array('id', 'isPayed'), array($order_id[$r], 'Yes'));
        }

        flash("msg", "success", "Successfully Paid");
        header("Location: ../View/receipt.php?reference_order=" . $reference_order[0]);
        exit();
    } else {
        flash("msg", "error", "File is not an image.");
        header("Location: ../View/payment.php");
        exit();
    }
} elseif (isset($_POST['DISAPPROVED'])) {
    $order_id = $_POST['order_id'];
    $getOrder = mysqli_fetch_assoc(getrecord('orders', 'id', $order_id));
    if($getOrder){
        updateUser('orders', array('id', 'status'), array($order_id, 'DisApprove'));

        $desc = 'Your Order with reference Order of ' . $getOrder['reference_order'] . ' was Disapproved';
        $notif = sendNotif('notification', 
                            array('user_id', 'date_send', 'isRead', 'redirect'), 
                            array($getOrder['user_id'], $date, 'No', 'myPurchase.php'));
        $last_id = mysqli_insert_id($conn);
        sendNotif(
            'notification_details',
            array('notification_id', 'title', 'Description'),
            array($last_id, 'Product Order', $desc)
        );
        flash("msg", "success", "Disapproved");
        header("Location: ../View/manageOrder.php");
        exit();
    }else{
        flash("msg", "error", "Error");
        header("Location: ../View/manageOrder.php");
        exit();
    }
} elseif (isset($_POST['APPROVE'])) {
    $order_id = $_POST['order_id'];
    $getOrder = mysqli_fetch_assoc(getrecord('orders', 'id', $order_id));

    if($getOrder){
        updateUser('orders', array('id', 'status','isAccept'), array($order_id, 'Approve','No'));

        $desc = 'Your Order with reference Order of ' . $getOrder['reference_order'] . ' was Approved';
        $notif = sendNotif('notification', 
                            array('user_id', 'date_send', 'isRead', 'redirect'), 
                            array($getOrder['user_id'], $date, 'No', 'myPurchase.php'));
        $last_id = mysqli_insert_id($conn);
        sendNotif(
            'notification_details',
            array('notification_id', 'title', 'Description'),
            array($last_id, 'Product Order', $desc)
        );
        flash("msg", "success", "Approved");
        header("Location: ../View/manageOrder.php");
        exit();
    }else{
        flash("msg", "error", "Error");
        header("Location: ../View/manageOrder.php");
        exit();
    }
} elseif (isset($_POST['SHIP_PRODUCT'])) {
    $order_id = $_POST['order_id'];
    $getOrder = mysqli_fetch_assoc(getrecord('orders', 'id', $order_id));
    $cart = mysqli_fetch_assoc(getrecord('carts', 'id', $getOrder['cart_id']));
    $product_details_etc = mysqli_fetch_assoc(getrecord('product_details_etc', 'product_id', $getOrder['product_id']));
    $newQuantity =  $product_details_etc['quantity'] - $cart['quantity'];

    if($getOrder){
        updateUser('orders', array('id', 'status'), array($order_id, 'Shipped'));
        updateUser('product_details_etc', array('product_id', 'quantity'), array($getOrder['product_id'],$newQuantity));

        $desc = 'Your Order with reference Order of ' . $getOrder['reference_order'] . ' was Shipped';
        $notif = sendNotif('notification', 
                            array('user_id', 'date_send', 'isRead', 'redirect'), 
                            array($getOrder['user_id'], $date, 'No', 'myPurchase.php'));
        $last_id = mysqli_insert_id($conn);
        sendNotif(
            'notification_details',
            array('notification_id', 'title', 'Description'),
            array($last_id, 'Product Order', $desc)
        );
        flash("msg", "success", "Product Shipped");
        header("Location: ../View/manageOrder.php");
        exit();
    }else{
        flash("msg", "error", "Error");
        header("Location: ../View/manageOrder.php");
        exit();
    }
} elseif (isset($_POST['DELETEORDER'])) {
    
    $order_id = $_POST['order_id'];
    $order = mysqli_fetch_assoc(getrecord('orders', 'id', $order_id));
    
    if ($order['status'] == 'DisApprove') {
        removeOrder($order_id);
        flash("msg", "success", "Order Deleted");
        header("Location: ../View/myPurchase.php");
        exit();
    } else {
        flash("msg", "error", "Can't Delete");
        header("Location: ../View/myPurchase.php");
        exit();
    }
} elseif (isset($_POST['RECEIVED'])) {
    $order_id = $_POST['order_id'];
    $getOrder = mysqli_fetch_assoc(getrecord('orders', 'id', $order_id));

    if($getOrder){
        updateUser('orders', array('id', 'status','isAccept'), array($order_id, 'Received','Yes'));

        $desc = 'Your Order with reference Order of ' . $getOrder['reference_order'] . ' was Received';
        $notif = sendNotif('notification', 
                            array('user_id', 'date_send', 'isRead', 'redirect'), 
                            array($getOrder['seller_id'], $date, 'No', 'myPurchase.php'));
        $last_id = mysqli_insert_id($conn);
        sendNotif(
            'notification_details',
            array('notification_id', 'title', 'Description'),
            array($last_id, 'Product Order', $desc)
        );
        flash("msg", "success", "Product Shipped");
        header("Location: ../View/myPurchase.php");
        exit();
    }else{
        flash("msg", "error", "Error");
        header("Location: ../View/myPurchase.php");
        exit();
    }
}


