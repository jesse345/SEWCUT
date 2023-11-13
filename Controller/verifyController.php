<?php
include("../Model/db.php");
session_start();
include '../includes/toastr.inc.php';

    $timestamp = date("Y-m-d H:i:s");
    $codes = mysqli_fetch_assoc(checkCode($_SESSION['id']));
  
    if(isset($_POST['VERIFY'])){
        $code = $_POST['code'];
        if( $codes['code'] == $code) {
            updateUser('users',
            array('id','email_verified_at','isVerify'),
            array($_SESSION['id'],$timestamp,"Yes"));
            flash("msg", "success", "Successfully verified");
            header("Location: ../View/index.php");
            exit();
        } else {
            flash("msg", "error", "Incorrect Verification code");
            header("Location: ../View/verify.php");
        }
    }
?>