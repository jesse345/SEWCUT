<?php
$conn;

function connect()
{
    global $conn;
    $conn = mysqli_connect('localhost', 'root', '', 'sewcut') or die("Connection Failed");
    return $conn;
}

include("userModel.php");

include("productModel.php");

include("wishlistModel.php");

include("cartModel.php");

include("orderModel.php");

include("notificationModel.php");

include("shopModel.php");

include("FeedbackModel.php");

function disconnect()
{
    global $conn;
    mysqli_close($conn);
}
