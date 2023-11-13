<?php
include("../Model/db.php");
session_start();
include '../includes/toastr.inc.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

if (isset($_POST['subscribe'])) {
    $user_id = $_SESSION['id'];
    $typeofpayment = 'Gcash';
    $amount = $_POST['amount'];
    $reference_number = $_POST['ref'];

    if ($amount == 199) {
        $type = "Standard";
    } elseif ($amount == 399) {
        $type = "Advance";
    } elseif ($amount == 699) {
        $type = "Premium";
    }

    createUser(
        'subscription',
        array('user_id', 'type', 'type_of_payment', 'amount', 'reference_number'),
        array($user_id, $type, $typeofpayment, $amount, $reference_number)
    );

    $targetDir = "../images/";
    $target_file = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);

    if ($check !== false) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        updateUser(
            'subscription',
            array('user_id', 'receipt_img'),
            array($_SESSION['id'], $target_file)
        );
    }
    flash("msg", "success", "Wait for the admin to verify your payment. Thank you!");
    header("Location: ../View/mySubscription.php");
    exit();
} elseif(isset($_POST['FREETRIAL'])){
    $currentDate = time();
    $oneMonth = 1 * 30 * 24 * 60 * 60;
    $dateexpire = $currentDate + $oneMonth; 
    $expirationDateFormatted = date("Y-m-d H:i:s", $dateexpire);
    $user = mysqli_fetch_assoc(getrecord('users','id',$_SESSION['id']));
    if($user['isSubscribe'] == 'Yes'){
        $userExtend = mysqli_fetch_assoc(ExtendSubscription($_SESSION['id']));
        $newExpireDate = $userExtend['date_expire'] + $expirationDateFormatte;

        updateUser('subscription',
                array('id','date_expire'),
                array($userExtend['id'], $newExpireDate));

        createUser('subscription', 
            array('user_id','type','status','date_start'),
            array($_SESSION['id'],'Free','Approve',$date));
        flash("msg", "success", "Successfully used free trial.");
        header("Location: ../View/mySubscription.php");
        exit();
    }else{
        createUser('subscription', 
                    array('user_id','type','status','date_start','date_expire'),
                    array($_SESSION['id'],'Free','Approve',$date,$expirationDateFormatted));

        updateUser('users',
                array('id','isSubscribe'),
                array($_SESSION['id'],'Yes'));
    }
    flash("msg", "success", "Successfully used free trial.");
    header("Location: ../View/mySubscription.php");
    exit();

}elseif(isset($_POST['FREETRIAL'])){
    createUser('subscription', 
                array('user_id','type'),
                array($_SESSION['id'],'Free'));
    flash("msg", "success", "Wait for the admin to verify your subscribtion. Thank you!");
    header("Location: ../View/mySubscription.php");
    exit();
}

