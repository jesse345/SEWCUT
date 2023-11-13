<?php


include "../Model/db.php";


if (isset($_POST['delete'])) {
    $notif_id = $_GET['notif_id'];
    deleteNotifs($notif_id);

    header("Location: ../Pages/Notification.php");
}
