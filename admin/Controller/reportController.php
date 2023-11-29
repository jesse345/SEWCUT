<?php
include('../../Model/db.php');
include('../../includes/toastr.inc.php');
session_start();


if (isset($_POST['REPORT'])) {
    $id = $_POST['id'];
    $days = $_POST['days'];

    // Calculate the new suspension date based on the current date and the provided number of days
    $newSuspensionDate = date('Y-m-d', strtotime("+$days days"));

    if($days != '') {
        updateUser('reports', array('id','suspension_date'), array($id,$newSuspensionDate));
         echo "<script>
                alert('Success');
                window.location.href = '../View/report.php';
              </script>";
    }else{
        echo "<script>  
                alert('Input Days');
                window.location.href = '../View/report.php';
              </script>";
    }
}

?>