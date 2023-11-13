<?php

function insertCart($table1,$fields1,$values1){
    global $conn;
    connect();
    // for cart
    $flds1 = implode("`,`", $fields1);
    $vals1 = implode("','", $values1);

    $query1  = mysqli_query($conn, "INSERT INTO `$table1` (`$flds1`) VALUES ('$vals1')");
    disconnect();
}

function countCart($id){
    global $conn; 
    connect();
    $query = mysqli_query($conn, "SELECT COUNT(*) FROM `carts` WHERE `user_id` = '$id' AND `isOrder` = 'No'");

    if ($query) {
        $count = mysqli_fetch_array($query)[0];
    } else {
        $count = 0; 
    }

    disconnect();
    return $count;
}

function getRecordCart($table,$value1,$value2){
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `user_id` = '$value1' && `product_id` = '$value2' && `isOrder` = 'No'");
    disconnect();
    return $query;
}

function removeCart($id,$product_id){
    global $conn;
    connect();
    mysqli_query($conn, "DELETE FROM `carts` WHERE `user_id` = '$id' AND `product_id` = '$product_id' AND `isOrder` = 'No' ");
    disconnect();
}

function displayCart($user_id){
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT distinct `seller_id`FROM `carts` WHERE `user_id` = '$user_id' AND `isOrder` = 'No'");
    disconnect();
    return $query;
}

function displayEachseller($user_id,$seller_id){
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `carts` WHERE `user_id` = '$user_id' AND `seller_id` = '$seller_id' AND `isOrder` = 'No'");
    disconnect();
    return $query;
}

function getProductPrice($product_id,$color,$size){
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `product_details_etc` 
                                            WHERE `product_id` = '$product_id'
                                            AND `color` = '$color'
                                            AND `size` = '$size' ");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}
function updateCart($table,$fields,$values){
    global $conn;
    connect();
    for($i = 1; $i < count($fields); $i++) {
         $query = mysqli_query($conn, "UPDATE `$table` SET `$fields[$i]` = '$values[$i]' WHERE `$fields[0]` = $values[0]");
    }
    disconnect();
    return $query;
}
