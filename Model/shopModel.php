<?php

function CreateShop($table1, $fields1, $values1)
{
    global $conn;
    connect();
    // for cart
    $flds1 = implode("`,`", $fields1);
    $vals1 = implode("','", $values1);

    $query1 = mysqli_query($conn, "INSERT INTO `$table1` (`$flds1`) VALUES ('$vals1')");
    return $query1;
}

function getShop($user_id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `shops` WHERE `user_id` = '$user_id'");
    // Return the result set as is
    return $query;
}

function displayShop()
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `shops`");
    return $query;
}

function distance($v1, $v2)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT id,user_id,shop_name,address, (3959 * acos(cos(radians($v1))
                        * cos(radians(latitude)) 
                        * cos(radians(longitude) 
                        - radians($v2)) 
                        + sin(radians($v1)) 
                        * sin(radians(latitude)))) 
                        AS distance 
                        FROM shops
                        HAVING 
                        distance 
                        < 25 ORDER BY distance
                        LIMIT 0, 10");
    ;
    disconnect();
    return $query;
}
