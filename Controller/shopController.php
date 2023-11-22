<?php
session_start();
include("../Model/db.php");
include '../includes/toastr.inc.php';
error_reporting(0);

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
    $height = empty($_POST['men_height']) ? $_POST['height'] : $_POST['men_height'];
    $bodice = empty($_POST['men_bodice']) ? $_POST['bodice'] : $_POST['men_bodice'];
    $bust = $_POST['under_bust'];
   
    // SHOP_HOMESERVICE
    $address = $_POST['address'];
    $schedule = $_POST['schedule'];

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

        if($address != '' && $schedule !=''){
            CreateShop(
                'shop_homeservice',
                array('shop_customoralter_id','address' ,'schedule'),
                array($shop_customoralter_id,$address,$schedule)
            );
        }
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

}

?>

