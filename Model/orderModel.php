<?php

function addOrder($table1, $fields1, $values1, $table2, $fields2, $values2)
{
    global $conn;
    connect();
    // for products
    $flds1 = implode("`,`", $fields1);
    $vals1 = implode("','", $values1);

    $flds2 = implode("`,`", $fields2);
    $vals2 = implode("','", $values2);

    $query1 = mysqli_query($conn, "INSERT INTO `$table1` (`$flds1`) VALUES ('$vals1')");
    $query2 = mysqli_query($conn, "INSERT INTO `$table2` (`$flds2`) VALUES((SELECT LAST_INSERT_ID()),'$vals2')");
    return $query1;
    disconnect();
}

function insertOrder($table, $fields, $values)
{
    global $conn;
    connect();
    // for cart
    $flds1 = implode("`,`", $fields);
    $vals1 = implode("','", $values);

    $query1 = mysqli_query($conn, "INSERT INTO `$table` (`$flds1`) VALUES ('$vals1')");
    disconnect();
}

function getOrder($table, $value)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `user_id` = '$value'");
    disconnect();
    return $query;
}

function removeOrder($order_id)
{
    global $conn;
    connect();
    mysqli_query($conn, "DELETE FROM `orders` WHERE `id`= '$order_id' ");
    mysqli_query($conn, "DELETE FROM `order_details` WHERE `id`= '$order_id' ");
    mysqli_query($conn, "DELETE FROM `order_payments` WHERE `order_id`= '$order_id' ");
    disconnect();
}

function getOrderbyID($table, $value)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `id` = '$value'");
    disconnect();
    return $query;
}

//Seller
function getOrderEachBuyer($table, $value)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT DISTINCT user_id FROM `$table` WHERE `seller_id` = '$value'");
    disconnect();
    return $query;
}

function getOrderSeller($table, $value)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `seller_id` = '$value' AND `status` != 'DisApprove'");
    disconnect();
    return $query;
}

function getOrderlimit5() 
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `orders` LIMIT 5");
    disconnect();
    return $query;
}

function getCountByCategory() {
    global $conn;
    connect();
    
    $query = mysqli_query($conn, "SELECT pd.category, COUNT(o.id) AS category_count
                                   FROM orders o
                                   JOIN product_details pd ON o.product_id = pd.id
                                   WHERE o.status = 'Approve'
                                   GROUP BY pd.category");
    
    disconnect();
    
    return $query;
}






