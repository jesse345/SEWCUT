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
    $currentDateTime = time();
    $subscription = mysqli_fetch_assoc(getrecord('subscription', 'id', $id));

    $subscriptionTimeLeft = mysqli_fetch_assoc(ExtendSubscription($subscription['user_id']));
    $dateLeftInTime = strtotime($subscriptionTimeLeft['date_expire']);

    if ($dateLeftInTime < $currentDateTime) {
        if($subscription['type'] == "Standard"){
            $threeMonths = 3 * 30 * 24 * 60 * 60;
            $dateexpire = $currentDateTime+ $threeMonths;
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
        } elseif($subscription['type'] == "Advance") {
            
            $sixMonths = (3 * 30 * 24 * 60 * 60) * 2; 
            $dateexpire = $currentDateTime+ $sixMonths; 
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
        } elseif($subscription['type'] == "Premium") {
            
            $oneYear = 365 * 24 * 60 * 60;
            $dateexpire = $currentDateTime+ $oneYear;
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
    } else {
        $timeLeft = $dateLeftInTime - $currentDateTime;
        
        if($subscription['type'] == "Standard"){
            $threeMonths = 3 * 30 * 24 * 60 * 60;
            $dateexpire = $currentDateTime + $threeMonths;
            $a = $timeLeft + $dateexpire;
            $expirationDateFormatted = date("Y-m-d H:i:s", $a);
            updateUser('subscription',
                        array('id','status','date_start','date_expire'),
                        array($id,'Approve',$date,$expirationDateFormatted));
                echo "<script>
                        alert('Accepted Successfully');
                        window.location.href = '../View/subscribe.php';
                    </script>";
        } elseif($subscription['type'] == "Advance") {
            $sixMonths = (3 * 30 * 24 * 60 * 60) * 2; 
            $dateexpire = $currentDateTime+ $sixMonths; 
            $a = $timeLeft + $dateexpire;
            $expirationDateFormatted = date("Y-m-d H:i:s", $a);
            updateUser('subscription',
                        array('id','status','date_start','date_expire'),
                        array($id,'Approve',$date,$expirationDateFormatted));
                echo "<script>
                        alert('Accepted Successfully');
                        window.location.href = '../View/subscribe.php';
                    </script>";
        } elseif($subscription['type'] == "Premium") {
            $oneYear = 365 * 24 * 60 * 60;
            $dateexpire = $currentDateTime+ $oneYear;
            $a = $timeLeft + $dateexpire;
            $expirationDateFormatted = date("Y-m-d H:i:s", $a);
            updateUser('subscription',
                        array('id','status','date_start','date_expire'),
                        array($id,'Approve',$date,$expirationDateFormatted));
                echo "<script>
                        alert('Accepted Successfully');
                        window.location.href = '../View/subscribe.php';
                    </script>";
        }
    }
}


?>