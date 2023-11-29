<?php
session_start();
include("../Model/db.php");
include '../includes/toastr.inc.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

if (isset($_POST['CREATESHOP'])) {
    $user_id = $_SESSION['id'];
    $shop_name = $_POST['shop_name'];
    $address_id = $_POST['address'];
    $can_alter = isset($_POST['can_alter']) ? 'Yes' : 'No';
    $can_customize = isset($_POST['can_customize']) ? 'Yes' : 'No';
    $can_homeservice = isset($_POST['homeservice']) ? 'Yes' : 'No';
    $address = mysqli_fetch_assoc(getrecord('address', 'id', $address_id));
    // SHOPS
    CreateShop(
        'shops',
        array('user_id', 'shop_name', 'address', 'canCustomize', 'canAlter','CanHomeService','latitude', 'longitude'),
        array($user_id, $shop_name, $address['address'], $can_alter, $can_customize,$can_homeservice, $address['latitude'], $address['longitude'])
    );
    $last_id = mysqli_insert_id($conn);
    // SHOP_DETAILS
    $Categorycustomize = isset($_POST['can_customize']) ? $_POST['can_customize'] : array();
    if (!empty($Categorycustomize)) {
        foreach ($Categorycustomize as $category) {
            CreateShop(
                'shop_details',
                array('shop_id', 'category'),
                array($last_id, $category)
            );
        }
    }
    flash("msg", "success", "Shop Created Successfully");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['NEARESTSHOP'])) {
    $v1 = $_POST['lats'];
    $v2 = $_POST['longs'];
    header("location: ../View/nearestShop.php?lat=$v1&long=$v2");
} elseif (isset($_POST['BINDGCASH'])) {
    flash("msg", "success", "Set Up Gcash Details First");
    header("Location: ../View/gcash_info.php");
    exit();
} elseif (isset($_POST['NEAR'])) {
    $nearestShops = distance1($_POST['lat'], $_POST['long']);
    if($nearestShops){
        echo json_encode($nearestShops); 
    }else{
        echo "error";
    }
} elseif (isset($_POST['CUSTOMIZESUBMIT'])) {
    // shop CustomOrAlter
    $shop_id = $_POST['shop_id'];
    $user_id = $_SESSION['id'];
    $status = "Pending";
    $type = "Customize";
    
    // SHOP INFO
    $name = $_POST['customer_name'];
    $phone = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $category = $_POST['category'];
    $instruction = $_POST['instruction'];

    // MEASUREMENTS
    $neck = empty($_POST['men_neck']) ? $_POST['neck'] : $_POST['men_neck'];
    $shoulder = empty($_POST['men_shoulder']) ? $_POST['shoulder'] : $_POST['men_shoulder'];
    $sleeve = empty($_POST['men_sleeve']) ? $_POST['sleeve'] : $_POST['men_sleeve'];
    $chest =  empty($_POST['men_chest']) ? $_POST['chest'] : $_POST['men_chest'];
    $waist = empty($_POST['men_waist']) ? $_POST['waist'] : $_POST['men_waist'];
    $hips =  empty($_POST['men_hips']) ? $_POST['hips'] : $_POST['men_hips'];
    $inseam = empty($_POST['men_inseam']) ? $_POST['inseam'] : $_POST['men_inseam'];
    $thigh = empty($_POST['men_thigh']) ? $_POST['thigh'] : $_POST['men_thigh'];
    //OPTIONAL
    $height = empty($_POST['men_height']) ? $_POST['height'] : $_POST['men_height'];
    $bodice = empty($_POST['men_bodice']) ? $_POST['bodice'] : $_POST['men_bodice'];
    $bust = $_POST['under_bust'];
   
    // SHOP_HOMESERVICE
    $address = $_POST['address'];
    $schedule = $_POST['schedule'];

    if($address == '' && $schedule ==''){
        if ($neck != '' && $shoulder != '' && $sleeve != '' && $chest != '' && $waist != '' && $hips != '' && $inseam != '' && $thigh != '') {
            $shopCustomize = CreateShop(
                'shop_customoralter',
                array('shop_id', 'user_id','status', 'type'),
                array($shop_id,$user_id,$status,$type)
            );
            $shop_customoralter_id = mysqli_insert_id($conn);
            
            if($shopCustomize){
                CreateShop(
                    'shop_info',
                    array('shop_customoralter_id','name' ,'phone', 'email','category','instruction'),
                    array($shop_customoralter_id,$name,$phone,$email,$category,$instruction)
                );
                $shopmeasurement_field = array('shop_customoralter_id','neck','shoulder','sleeve','chest','waist','hips','inseam','thigh','height','bodice','bust');
                $shopmeasurement_value = array($shop_customoralter_id,$neck,$shoulder,$sleeve,$chest,$waist,$hips,$inseam,$thigh,$height,$bodice,$bust);
                $shop_measurements= CreateShop('shop_measurerments',$shopmeasurement_field, $shopmeasurement_value);
                $targetDir = "../images/";
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];

                foreach ($_FILES['image']['name'] as $key => $name) {
                    $fileType = pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
                    $targetPath = $targetDir . basename($name);

                    if (in_array($fileType, $allowedTypes)) {
                        move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetPath);
                        insertProduct(
                            'shop_images',
                            array('shop_customoralter_id', 'images'),
                            array($shop_customoralter_id, $targetPath)
                        );
                    } else {
                        echo "Invalid file type: $name<br>";
                    }
                }

                    $shop1 = mysqli_fetch_assoc(getrecord('shops', 'id', $shop_id));
                    $getUser = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
                    $desc = $getUser['firstname'] . " " . $getUser['lastname'] . " Wants to Customize a product";
                    $notif = sendNotif('notification', array('user_id', 'date_send', 'isRead', 'redirect'), array($shop1['user_id'], $date, 'No', 'myShop.php'));
                    $last_id = mysqli_insert_id($conn);
                    sendNotif(
                        'notification_details',
                        array('notification_id', 'title', 'Description'),
                        array($last_id, 'Product Order', $desc)
                    );
                
                flash("msg", "success", "Success");
                header("Location:../View/customAndAlter.php");
                exit();
            }else{
                flash("msg", "error", "Theres in an error");
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }else{
            flash("msg", "info", "Input all the fields in Measurements.");
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }else{
        $shopCustomize = CreateShop(
            'shop_customoralter',
            array('shop_id', 'user_id','status', 'type'),
            array($shop_id,$user_id,$status,$type)
        );
        $shop_customoralter_id = mysqli_insert_id($conn);
        if($shopCustomize){
                CreateShop(
                    'shop_info',
                    array('shop_customoralter_id','name' ,'phone', 'email','category','instruction'),
                    array($shop_customoralter_id,$name,$phone,$email,$category,$instruction)
                );
                CreateShop(
                    'shop_homeservice',
                    array('shop_customoralter_id','address' ,'schedule'),
                    array($shop_customoralter_id,$address,$schedule)
                );
                $targetDir = "../images/";
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];

                foreach ($_FILES['image']['name'] as $key => $name) {
                    $fileType = pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
                    $targetPath = $targetDir . basename($name);

                    if (in_array($fileType, $allowedTypes)) {
                        move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetPath);
                        insertProduct(
                            'shop_images',
                            array('shop_customoralter_id', 'images'),
                            array($shop_customoralter_id, $targetPath)
                        );
                    } else {
                        echo "Invalid file type: $name<br>";
                    }
                }

                    $shop1 = mysqli_fetch_assoc(getrecord('shops', 'id', $shop_id));
                    $getUser = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
                    $desc = $getUser['firstname'] . " " . $getUser['lastname'] . " Wants to Customize a product";
                    $notif = sendNotif('notification', array('user_id', 'date_send', 'isRead', 'redirect'), array($shop1['user_id'], $date, 'No', 'myShop.php'));
                    $last_id = mysqli_insert_id($conn);
                    sendNotif(
                        'notification_details',
                        array('notification_id', 'title', 'Description'),
                        array($last_id, 'Product Order', $desc)
                    );
                
                flash("msg", "success", "Success");
                header("Location:../View/customAndAlter.php");
                exit();
        }else{
            flash("msg", "error", "Theres in an error");
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    
    
} elseif (isset($_POST['BTN_APPROVE'])) {
    $id = $_POST['id'];

    $status = "Approved";
    updateUser(
        'shop_customoralter',
        array('id', 'status'),
        array($id, $status)
    );

    $shop_customoralter = mysqli_fetch_assoc(getrecord('shop_customoralter', 'id', $id));
    $shop = mysqli_fetch_assoc(getrecord('shops', 'id',$shop_customoralter['shop_id'] ));
    $desc = $shop['shop_name'] . "Apprroved your Custimization product";
    $notif = sendNotif('notification', array('user_id', 'date_send', 'isRead', 'redirect'), array($shop_customoralter['user_id'], $date, 'No', 'customAndAlter.php'));
    $last_id = mysqli_insert_id($conn);
    sendNotif(
        'notification_details',
        array('notification_id', 'title', 'Description'),
        array($last_id, 'Product Order', $desc)
    );
    flash("msg", "success", "Success");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['BTN_DISAPPROVE'])) {
    $id = $_POST['id'];
    $status = "DisApproved";
    updateUser(
        'shop_customoralter',
        array('id', 'status'),
        array($id, $status)
    );

    $shop_customoralter = mysqli_fetch_assoc(getrecord('shop_customoralter', 'id', $id));
    $shop = mysqli_fetch_assoc(getrecord('shops', 'id',$shop_customoralter['shop_id'] ));
    $desc = $shop['shop_name'] . "DisApprroved your Custimization product";
    $notif = sendNotif('notification', array('user_id', 'date_send', 'isRead', 'redirect'), array($shop_customoralter['user_id'], $date, 'No', 'customAndAlter.php'));
    $last_id = mysqli_insert_id($conn);
    sendNotif(
        'notification_details',
        array('notification_id', 'title', 'Description'),
        array($last_id, 'Product Order', $desc)
    );
    
    flash("msg", "success", "Success");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['ALTERSUBMIT'])) {
    // shop CustomOrAlter
    $shop_id = $_POST['shop_id'];
    $user_id = $_SESSION['id'];
    $status = "Pending";
    $type = "Alter";
    
    // SHOP INFO
    $name = $_POST['customer_name'];
    $phone = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $instruction = $_POST['instruction'];


    // ALTER 
    if(empty($_POST['altertype'])) {
        $altertype = $_POST['option_altertype'];
    } else {
        $altertype = $_POST['altertype'];
    }

    // GARMENT
    if(empty($_POST['garmenttype'])) {
        $garmentstype = $_POST['garmenttype_other'];
    } else {
        $garmentstype = $_POST['garmenttype'];
    }

    echo $garmentstype;
    echo $altertype;



    // MEASUREMENTS
    $neck = empty($_POST['men_neck']) ? $_POST['neck'] : $_POST['men_neck'];
    $shoulder = empty($_POST['men_shoulder']) ? $_POST['shoulder'] : $_POST['men_shoulder'];
    $sleeve = empty($_POST['men_sleeve']) ? $_POST['sleeve'] : $_POST['men_sleeve'];
    $chest =  empty($_POST['men_chest']) ? $_POST['chest'] : $_POST['men_chest'];
    $waist = empty($_POST['men_waist']) ? $_POST['waist'] : $_POST['men_waist'];
    $hips =  empty($_POST['men_hips']) ? $_POST['hips'] : $_POST['men_hips'];
    $inseam = empty($_POST['men_inseam']) ? $_POST['inseam'] : $_POST['men_inseam'];
    $thigh = empty($_POST['men_thigh']) ? $_POST['thigh'] : $_POST['men_thigh'];
    $height = empty($_POST['men_height']) ? $_POST['height'] : $_POST['men_height'];
    $bodice = empty($_POST['men_bodice']) ? $_POST['bodice'] : $_POST['men_bodice'];
    $bust = $_POST['under_bust'];
   
    $shopCustomize = CreateShop(
        'shop_customoralter',
        array('shop_id', 'user_id','status', 'type'),
        array($shop_id,$user_id,$status,$type)
    );
    $shop_customoralter_id = mysqli_insert_id($conn);
    
    if($shopCustomize){
        CreateShop(
            'shop_info',
            array('shop_customoralter_id','name' ,'phone', 'email','instruction'),
            array($shop_customoralter_id,$name,$phone,$email,$instruction)
        );
        $shopmeasurement_field = array('shop_customoralter_id','neck','shoulder','sleeve','chest','waist','hips','inseam','thigh','height','bodice','bust','garment_type','alter_type');
        $shopmeasurement_value = array($shop_customoralter_id,$neck,$shoulder,$sleeve,$chest,$waist,$hips,$inseam,$thigh,$height,$bodice,$bust,$garmentstype,$altertype);
        $shop_measurements= CreateShop('shop_measurerments',$shopmeasurement_field, $shopmeasurement_value);

        $targetDir = "../images/";
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];

        foreach ($_FILES['image']['name'] as $key => $name) {
            $fileType = pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
            $targetPath = $targetDir . basename($name);

            if (in_array($fileType, $allowedTypes)) {
                move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetPath);
                insertProduct(
                    'shop_images',
                    array('shop_customoralter_id', 'images'),
                    array($shop_customoralter_id, $targetPath)
                );
            } else {
                echo "Invalid file type: $name<br>";
            }
        }
        $shop1 = mysqli_fetch_assoc(getrecord('shops', 'id', $shop_id));
        $getUser = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
        $desc = $getUser['firstname'] . " " . $getUser['lastname'] . " Wants to Alter a product";
        $notif = sendNotif('notification', array('user_id', 'date_send', 'isRead', 'redirect'), array($shop1['user_id'], $date, 'No', 'myShop.php'));
        $last_id = mysqli_insert_id($conn);
        sendNotif(
            'notification_details',
            array('notification_id', 'title', 'Description'),
            array($last_id, 'Product Order', $desc)
        );

        flash("msg", "success", "Success");
        header("Location:../View/customAndAlter.php");
        exit();
    }else{
        flash("msg", "error", "Theres in an error");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    
    
} elseif (isset($_POST['CANCEL'])) {
    $id =  $_POST['custom_alterid'];
    $order = mysqli_fetch_assoc(getrecord('shop_customoralter', 'id', $id));

    $created_at_timestamp = strtotime($order['created_at']);
    $current_timestamp = time();
    $time_difference = $current_timestamp - $created_at_timestamp;
    $time_in_hours = $time_difference / 3600; 

    if ($time_in_hours < 24) {
        removeCustomOrAlter($id);
        flash("msg", "success", "Cancelled");
        header("Location: ../View/customAndAlter.php");
        exit();
    } else {
       flash("msg", "error", "Cant Cancel over 24 hours");
        header("Location: ../View/customAndAlter.php");
        exit();
    }

} elseif (isset($_POST['SETPRICE'])) {
    $id = $_POST['shop_customOrAlter_id'];
    $price = $_POST['price'];

    $gcash_name = $_POST['gcash_name'];
    $gcash_number = $_POST['gcash_number'];



    updateUser(
        'shop_customoralter',
        array('id', 'price'),
        array($id, number_format($price,2))
    );

    CreateShop('shop_seller_paymentinfo',
                    array('shop_customoralter_id','gcash_name','gcash_number'),
                    array($id,$gcash_name,$gcash_number));

    flash("msg", "success", "Price successfully set");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['CHOOSEPAYMENT'])) {
    $shop_customoralter_id = $_POST['shop_customoralter_id'];
    $payment_type = $_POST['payment-type'];
    $fullname = $_POST['fullname'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];

    updateUser(
        'shop_customoralter',
        array('id', 'payment_type'),
        array($shop_customoralter_id, $payment_type)
    );

    insertProduct('shop_buyer_shippinginfo',
        array('shop_customoralter_id', 'fullname', 'contact_number', 'address'),
        array($shop_customoralter_id, $fullname, $contact_number, $address));

    if ($payment_type == "Cash On Delivery") {
        flash("msg", "success", "Payment type set to Cash on Delivery");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Redirect to the appropriate page based on your logic
        header("Location: ../View/customOrAlterPayment.php?shop_customOrAlter=" . $shop_customoralter_id);
        exit();
    }
} elseif (isset($_POST['ADDFEEDBACK'])) {
    $id = $_POST['id'];
    $user_id = $_SESSION['id'];
    $feedback = $_POST['feedback'];
    
    if($feedback != ''){
        CreateShop('shop_feedbacks',
                    array('shop_customoralter_id','user_id','feedbacks'),
                    array($id,$user_id,$feedback));
        flash("msg", "success", "Success");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }else{
        flash("msg", "info", "Input Something");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} elseif (isset($_POST['CHANGEPAYMENTINFO'])) {
    $id = $_POST['shop_seller_paymentinfo_id'];
    $gcash_name = $_POST['gcash_name'];
    $gcash_number = $_POST['gcash_number'];

    updateUser(
        'shop_seller_paymentinfo',
        array('id', 'gcash_name','gcash_number'),
        array($id, $gcash_name,$gcash_number)
    );
    flash("msg", "success", "Payment Info successfully set");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['CUSTOMORALTER_PAY'])) {
    $custom_alter_id = $_POST['custom_alter_id'];
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $reference_order = substr(str_shuffle($characters . time() * rand()), 0, 20);
    $amount = $_POST['price'];
    $reference_number = $_POST['reference_number'];

    $targetDir = "../images/";
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];

    // Assuming you have a loop for multiple files
    foreach ($_FILES['image']['name'] as $key => $name) {
        $fileType = pathinfo($name, PATHINFO_EXTENSION);
        $targetPath = $targetDir . basename($name);

        // Check if the file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetPath)) {
                // Insert data into the database
                insertProduct(
                    'shop_customoralter_payments',
                    array('shop_customoralter_id', 'reference_order', 'receipt_image', 'amount', 'reference_number'),
                    array($custom_alter_id, $reference_order, $targetPath, $amount, $reference_number)
                );
            } else {
                // Handle file upload error
                echo 'File upload failed.';
            }
        } else {
            // Handle invalid file type
            echo 'Invalid file type.';
        }
    }
    flash("msg", "success", "Successfully Paid");
    header("Location: ../View/customOrAlterReceipt.php?customOrAlter_id=" . $custom_alter_id);
    exit();
} elseif (isset($_POST['CHANGSHIPPING'])) {
    $id = $_POST['shipping_info_id'];
    $seller = $_POST['seller_id'];
    updateUser(
        'shipping_info',
        array('id','created_at'),
        array($id, $date)
    );
    flash("msg", "success", "Shipping Info Changed");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['ADDSHIPPINGINFO'])) {
    $user_id = $_SESSION['id'];
    $name = $_POST['fullname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    if($name != '' && $contact != '' && $address != ''){

        insertCart('shipping_info',
                array('user_id','name','contact','address'),
                array($user_id,$name,$contact,$address));
        flash("msg", "success", "Added successfully");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        flash("msg", "info", "Fill up all the fields");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

} elseif (isset($_POST['DELETESHIPPINGINFO'])) {
    $ID = $_POST['ID'];
    deleteUser('shipping_info', 'id', $ID);
} elseif (isset($_POST['SHIPPRODUCT'])) {
    $shop_customoralter_id = $_POST['id'];
    $status = "Shipped";
    
    updateUser(
            'shop_customoralter',
            array('id', 'status'),
            array($shop_customoralter_id, $status)
        );
    flash("msg", "success", "Success");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} elseif (isset($_POST['RECEIVE'])) {
    $id =  $_POST['custom_alterid'];
    $status = "Received";

    updateUser(
        'shop_customoralter',
        array('id', 'status'),
        array($id, $status)
    );
    flash("msg", "success", "Received");
    header("Location: ../View/customAndAlter.php");
    exit();
}
   

?>