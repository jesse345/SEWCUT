<?php
session_start();
include '../includes/toastr.inc.php';

if (isset($_POST['submit'])) {
    flash("msg", "success", "This is an error message."); // Store an error message
    header("location: toastr.php");
    exit();
}
?>
