<?php
include('../../Model/db.php');
include('../../Includes/toastr.inc.php');
session_start();
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

if (isset($_POST['REJECT'])) {
    $id = $_POST['subscription_id'];
    $subscription = mysqli_fetch_assoc(getrecord('subscription','id',$id));

    $description = "Your Subscription has been Rejected";
    $notif = sendNotif('notification', 
                        array('user_id', 'date_send', 'isRead', 'redirect'), 
                        array($subscription['user_id'], $date, 'No', 'mySubscription.php'));
    $last_id = mysqli_insert_id($conn);
    sendNotif(
        'notification_details',
        array('notification_id', 'title', 'Description'),
        array($last_id, 'Subscription', $description)
    );
    updateUser('subscription',
                array('id','status'),
                array($id,'Reject'));
     echo "<script>
                alert('Rejected Successfully');
                window.location.href = '../View/subscribe.php';
              </script>";
}elseif (isset($_POST['ACCEPT'])){
    $id = $_POST['subscription_id'];
    $subscription = mysqli_fetch_assoc(getrecord('subscription','id',$id));

    if($subscription['type'] == "Free"){
        $currentDate = time();
        $oneWeek = 7 * 24 * 60 * 60;
        $dateexpire = $currentDate + $oneWeek; 
        $expirationDateFormatted = date("Y-m-d H:i:s", $dateexpire);
        updateUser('subscription',
                array('id','status','date_start','date_expire'),
                array($id,'Approve',$date,$expirationDateFormatted));

        updateUser('users',
                array('id','isSubscribe'),
                array($subscription['user_id'],'Yes'));
        echo "<script>
                alert('Accepted Successfully');
                window.location.href = '../View/subscribe.php';
              </script>";
    }elseif($subscription['type'] == "Standard"){
        $currentDate = time();
        $threeMonths = 3 * 30 * 24 * 60 * 60;
        $dateexpire = $currentDate + $threeMonths;
        $expirationDateFormatted = date("Y-m-d H:i:s", $dateexpire);
        updateUser('subscription',
                    array('id','status','date_start','date_expire'),
                    array($id,'Approve',$date,$expirationDateFormatted));

            updateUser('users',
                    array('id','isSubscribe'),
                    array($subscription['user_id'],'Yes'));
            echo "<script>
                    alert('Accepted Successfully');
                    window.location.href = '../View/subscribe.php';
                </script>";
    }elseif($subscription['type'] == "Advance"){
        $currentDate = time();
        $sixMonths = (3 * 30 * 24 * 60 * 60) * 2; 
        $dateexpire = $currentDate + $sixMonths; 
        $expirationDateFormatted = date("Y-m-d H:i:s", $dateexpire);
        updateUser('subscription',
                    array('id','status','date_start','date_expire'),
                    array($id,'Approve',$date,$expirationDateFormatted));

            updateUser('users',
                    array('id','isSubscribe'),
                    array($subscription['user_id'],'Yes'));
            echo "<script>
                    alert('Accepted Successfully');
                    window.location.href = '../View/subscribe.php';
                </script>";
    }elseif($subscription['type'] == "Premium"){
       $currentDate = time();
        $oneYear = 365 * 24 * 60 * 60;
        $dateexpire = $currentDate + $oneYear;
        $expirationDateFormatted = date("Y-m-d H:i:s", $dateexpire);
        updateUser('subscription',
                    array('id','status','date_start','date_expire'),
                    array($id,'Approve',$date,$expirationDateFormatted));

            updateUser('users',
                    array('id','isSubscribe'),
                    array($subscription['user_id'],'Yes'));
            echo "<script>
                    alert('Accepted Successfully');
                    window.location.href = '../View/subscribe.php';
                </script>";
    }
    
}


?>