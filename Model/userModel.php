<?php
function loginAdmin($username, $password)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `admin` WHERE `username` = '$username'  AND `password` = '$password'");
    disconnect();
    return $query;
}
function login($username, $password)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE (`username` = '$username' OR `email` = '$username') AND `password` = '$password'");
    disconnect();
    return $query;
}
function getallrecord($table)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table`");
    disconnect();
    return $query;
}

function getrecord($table, $field, $value)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$field` = '$value'");
    disconnect();
    return $query;
}

function createUser($table, $fields, $values)
{
    global $conn;
    connect();
    $flds = implode("`,`", $fields);
    $vals = implode("','", $values);
    $query = mysqli_query($conn, "INSERT INTO `$table` (`$flds`) VALUES ('$vals')");
    disconnect();
}

function addUser($table1, $fields1, $values1, $table2, $fields2, $values2)
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

function updateUser($table, $fields, $values)
{
    global $conn;
    connect();
    for ($i = 1; $i < count($fields); $i++) {
        $query = mysqli_query($conn, "UPDATE `$table` SET `$fields[$i]` = '$values[$i]' WHERE `$fields[0]` = $values[0]");
    }
    disconnect();
    return $query;
}

function checkCode($user_id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `verification_codes` WHERE `user_id` = $user_id ORDER BY `id` DESC  LIMIT 1;");

    disconnect();
    return $query;
}

function checkUser($field, $value, $id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `$field` = '$value' AND id != '$id'");

    disconnect();
    return $query;
}

function sizeOrColor($table)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM $table");
    disconnect();
    return $query;
}

function countSizeOrColor($product_id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT count(*) from product_colors where `product_id` = '$product_id'");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function countVerify()
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT count(isVerify)  as verify FROM users WHERE  `isVerify` = 'Yes' ");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function countNotVerify()
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT count(isVerify) as verify FROM users WHERE  `isVerify` = 'No' ");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function countAllUser()
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT count(*) as users FROM users");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function countAllProductSold()
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT COUNT(*) AS product_sold FROM `orders` WHERE STATUS = 'Approve'");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function countAllSubscribers()
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT COUNT(*) AS subscribers FROM `subscription`");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function countAlllTotalRevenue()
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT SUM(amount) AS total_revenue FROM `subscription` WHERE STATUS = 'Approve'");
    $row = mysqli_fetch_assoc($query);
    disconnect();
    return $row;
}

function deleteUser($table, $field, $value)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "DELETE FROM `$table` WHERE `$field` = '$value'");
    disconnect();
    return $query;
}

function subscriptionForFree($user_id){
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `subscription` WHERE `user_id` = '$user_id' && `type` = 'Free'");
    disconnect();
    return $query;
}

function isUserSubscribe($user_id){
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$user_id' && `isSubscribe` = 'Yes'");
    disconnect();
    return $query;
}

function ExtendSubscription($user_id){
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `subscription` WHERE `user_id` = '$user_id' GROUP BY id ASC LIMIT 1;");
    disconnect();
    return $query;
}

?>

