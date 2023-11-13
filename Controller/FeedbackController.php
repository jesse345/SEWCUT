<?php
session_start();
include("../Model/db.php");
include '../includes/toastr.inc.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');


if (isset($_POST['REVIEW'])) {
    
    $fld = array('user_id','order_id', 'product_id', 'rate', 'description');
    $val = array($_SESSION['id'],$_POST['order_id'], $_GET['product_id'], $_POST['rating'], $_POST['feedback']);
    insertProductReviews('feedbacks', $fld, $val);
    flash("msg", "success", "Successfully Paid");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
