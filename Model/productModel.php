<?php

function addProduct($table1, $fields1, $values1, $table2, $fields2, $values2)
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

function insertProduct($table1, $fields1, $values1)
{
    global $conn;
    connect();
    // for products
    $flds1 = implode("`,`", $fields1);
    $vals1 = implode("','", $values1);

    $query1 = mysqli_query($conn, "INSERT INTO `$table1` (`$flds1`) VALUES ('$vals1')");
    disconnect();
}

function displayProduct($table)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM $table");
    return $query;
    disconnect();
}
function displayProductInShop($table, $field1, $value1, $value2)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$field1` = '$value1' AND `inShop` = '$value2'");
    return $query;
    disconnect();
}


function displayDetails($table, $field, $value)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$field` = '$value'");
    return $query;
    disconnect();
}

function displayDetailsETC($table, $value1, $value2, $value3)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `product_id` = '$value1' AND `color` = '$value2' AND `size` = '$value3'");
    return $query;
    disconnect();
}

function updateProduct($table, $fields, $values)
{
    global $conn;
    connect();
    for ($i = 1; $i < count($fields); $i++) {
        $query = mysqli_query($conn, "UPDATE `$table` SET `$fields[$i]` = '$values[$i]' WHERE `$fields[0]` = $values[0]");
    }
    disconnect();
    return $query;
}

function countCategory($category)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT COUNT(*) as category_count FROM `product_details` WHERE `category` = '$category'");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function deleteProduct($id)
{
    global $conn;
    connect();

    // Delete the product record from the products table
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");

    mysqli_query($conn, "DELETE FROM product_images WHERE product_id = $id");


    // Delete records from the product_quantity table
    mysqli_query($conn, "DELETE FROM product_details_etc WHERE product_id = $id");

    disconnect();
}

function minPrice($product_id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT MIN(price) as price
                                    FROM product_details_etc
                                    WHERE `product_id` = '$product_id'");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function maxPrice($product_id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT MAX(price) as price
                                    FROM product_details_etc
                                    WHERE `product_id` = '$product_id'");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function sumOfProduct($product_id)
{
    global $conn;
    connect();
    connect();
    $query = mysqli_query($conn, "SELECT SUM(quantity) as total FROM `product_details_etc` WHERE `product_id` = '$product_id'");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function getQuantity($product_id, $color, $size)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT quantity,price FROM product_details_etc 
                                    WHERE `product_id` = '$product_id'
                                    AND `color` = '$color'
                                    AND `size` = '$size' ");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function getQuanityUsingColor($product_id, $color)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT SUM(quantity) as quantity FROM product_details_etc WHERE `product_id` = '$product_id'   AND `color` = '$color'");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}
