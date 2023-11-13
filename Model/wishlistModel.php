<?php


function removeWishlist($id, $product_id)
{
    global $conn;
    connect();
    mysqli_query($conn, "DELETE FROM wishlists WHERE user_id = '$id' AND product_id = '$product_id'");
    disconnect();
}

function countWishlist($id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT COUNT(*) FROM wishlists WHERE user_id = $id");

    if ($query) {
        $count = mysqli_fetch_array($query)[0];
    } else {
        $count = 0;
    }

    disconnect();
    return $count;
}

function getRecordWishlist($table, $value1, $value2)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `user_id` = '$value1' && `product_id` = '$value2'");
    disconnect();
    return $query;
}

function getWishlist($value)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `wishlists` WHERE `user_id` = '$value'");
    disconnect();
    return $query;
}

function removeTOWishlist($id)
{
    global $conn;
    connect();
    mysqli_query($conn, "DELETE FROM `wishlists` WHERE `id` = '$id'");
    disconnect();
}
