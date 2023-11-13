<?php


function insertProductReviews($table_name, $fields, $values)
{
    global $conn;
    connect();
    //for products table
    $flds = implode("`,`", $fields);
    $vals = implode("','", $values);
    $query = mysqli_query($conn, "INSERT INTO `$table_name` (`$flds`) VALUES ('$vals') ");
    disconnect();
}

function getProductReviews($table_name, $fields, $values)
{
    global $conn;
    connect();
    $query = "SELECT * FROM `$table_name` WHERE `$fields` = $values ";
    $data = mysqli_query($conn, $query);
    disconnect();
    return $data;
}

function userProductReviews($user_id, $product_id,$order_id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `feedbacks` WHERE `user_id` = $user_id AND `product_id` = $product_id AND `order_id` = $order_id");
    disconnect();
    return $query;
}

function countReview($product_id){
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT COUNT(*) AS count_review FROM `feedbacks` WHERE `product_id` = $product_id");
    $row = mysqli_fetch_assoc($query);
    return $row;
}
