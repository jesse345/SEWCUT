<?php
session_start();
include("../Model/db.php");
error_reporting(0);

if (isset($_POST["color"]) && isset($_POST["size"])) {

    $product_id = $_POST["product_id"];
    $color = $_POST["color"];
    $size = $_POST["size"];

    $quantity = getQuantity($product_id, $color, $size);
    $quantityColor = getQuanityUsingColor($product_id,$color);

    if(empty($size)){
         echo $quantityColor['quantity'];
    }else{
         if($quantity['quantity'] != null){
            echo $quantity['quantity'];
         }else{
            echo 0;
         }
    }
}