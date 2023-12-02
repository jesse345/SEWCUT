<?php
include('../../Model/db.php');
include('../../includes/toastr.inc.php');
session_start();


if (isset($_POST['REPORT'])) {
    $id = $_POST['id'];
    $days = $_POST['days'];

    $newSuspensionDate = date('Y-m-d', strtotime("+$days days"));
    $r = mysqli_fetch_assoc(getrecord('reports','id',$id));
    $user = mysqli_fetch_assoc(getrecord('reports','id',$id));
    $re = mysqli_fetch_assoc(reports($r['seller_id']));
    $currentDateTime = time();
    if($days != '') {

      if (strtotime($re['suspension_date']) > $currentDateTime) {
            echo "<script>  
                alert('Cant Suspend Due Ongoing suspension');
                window.location.href = '../View/report.php';
              </script>";
      }else{
        updateUser('reports', array('id','suspension_date'), array($id,$newSuspensionDate));
         echo "<script>
                alert('Success');
                window.location.href = '../View/report.php';
              </script>";
      }
    }else{
        echo "<script>  
                alert('Please Select Days');
                window.location.href = '../View/report.php';
              </script>";
    }
}elseif (isset($_POST['REVERT'])) {
  $id = $_POST['id'];
  $newSuspensionDate = '0000-00-00 00:00:00';
  
  updateUser('reports', array('id','suspension_date'), array($id,$newSuspensionDate));
  echo "<script>
                alert('Success');
                window.location.href = '../View/report.php';
              </script>";
}

?>