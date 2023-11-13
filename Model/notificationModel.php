<?php

function sendNotif($table_name, $fields, $values)
{
    global $conn;
    connect();
    //for notification table
    $flds = implode("`,`", $fields);
    $vals = implode("','", $values);

    $query = mysqli_query($conn, "INSERT INTO `$table_name` (`$flds`) VALUES ('$vals')");
    return $query;
}

function viewAllNotif($table_name, $fld, $val, $id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `$table_name` WHERE $fld = $val ORDER BY `$id` DESC");

    disconnect();
    return $query;
}

function deleteNotifs($id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "DELETE FROM `notification` WHERE `id` = $id");
    disconnect();
}


function markAsRead($id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "UPDATE  `notification` SET `isRead` = 'Yes' WHERE `user_id` = $id");
    disconnect();
}


function unRead($id)
{
    global $conn;
    connect();
    $query = mysqli_query($conn, "SELECT * FROM `notification` WHERE `user_id` = $id AND `isRead` = 'No'");

    disconnect();
    return $query;
}
