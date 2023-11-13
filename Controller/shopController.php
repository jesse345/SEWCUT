<?php
session_start();
include("../Model/db.php");
include '../includes/toastr.inc.php';

if (isset($_POST['CREATESHOP'])) {
    $user_id = $_SESSION['id'];
    $shop_name = $_POST['shop_name'];
    $address_id = $_POST['address'];
    $can_alter = isset($_POST['can_alter']) ? 'Yes' : 'No';
    $can_customize = isset($_POST['can_customize']) ? 'Yes' : 'No';
    $address = mysqli_fetch_assoc(getrecord('address', 'id', $address_id));
    // SHOPS
    CreateShop(
        'shops',
        array('user_id', 'shop_name', 'address','canCustomize','canAlter', 'latitude', 'longitude'),
        array($user_id, $shop_name, $address['address'],$can_alter,$can_customize, $address['latitude'], $address['longitude'])
    );
    $last_id = mysqli_insert_id($conn);
    // SHOP_DETAILS
    $Categorycustomize = isset($_POST['can_customize']) ? $_POST['can_customize'] : array();
    if (!empty($Categorycustomize)) {
        foreach ($Categorycustomize as $category) {
            CreateShop(
                'shop_details',
                array('shop_id','category'),
                array($last_id,$category)
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
}
