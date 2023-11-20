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
    $type = "Customization";
    
    // SHOP INFO
    $name = $_POST['customer_name'];
    $phone = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $category = $_POST['category'];
    $instruction = $_POST['instruction'];

    // MEASUREMENTS
    $neck = $_POST['neck'];
    $shoulder = $_POST['shoulder'];
    $sleeve = $_POST['sleeve'];
    $chest = $_POST['chest'];
    $waist = $_POST['waist'];
    $hips = $_POST['hips'];
    $inseam = $_POST['inseam'];
    $thigh = $_POST['thigh'];
    $height = $_POST['height'];
    $bodice = $_POST['bodice'];
    $bust = $_POST['under_bust'];

    // SHOP_HOMESERVICE
    $address = $_POST['address'];
    $schedule = $_POST['schedule'];

    $shopCustomize = CreateShop(
        'shop_customoralter',
        array('shop_id', 'user_id', 'type'),
        array($shop_id,$user_id,$type)
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
        CreateShop('shop_measurerments',$shopmeasurement_field, $shopmeasurement_value);
        CreateShop(
            'shop_homeservice',
            array('shop_customoralter_id','address' ,'schedule'),
            array($shop_customoralter_id,$address,$schedule)
        );
        // flash("msg", "success", "Success");
        // header("Location: " . $_SERVER['HTTP_REFERER']);
        // exit();
    }else{
        // flash("msg", "error", "Theres in an error");
        // header("Location: " . $_SERVER['HTTP_REFERER']);
        // exit();
    }

    
    
}

?>

