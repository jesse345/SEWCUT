<?php
include("../Model/db.php");
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../assets/css/notification.css">
    <?php include("../layouts/head.layout.php") ?>
    <title>My Account</title>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-5">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notification</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="page-content-layout">
                <div class="notification-ui_dd-content container">
                    <?php $notifications = viewAllNotif('notification', 'user_id', $_SESSION['id'], 'id');
                    while ($notification = mysqli_fetch_assoc($notifications)) {
                        $notif = mysqli_fetch_assoc(viewAllNotif('notification_details', 'notification_id', $notification['id'], 'notification_id'));
                        ?>
                        <a href="<?php echo $notification['redirect'] ?>">
                            <div class="notification-list">
                                <div class="notification-list_content">
                                    <div class="notification-list_detail">
                                        <p><b>
                                                <?php echo $notif['title'] ?>
                                            </b> </p>
                                        <p class="text-muted">
                                            <?php echo $notif['Description'] ?>
                                        </p>
                                        <?php
                                        $time = strtotime($notification['date_send']);
                                        $currentTimestamp = time();
                                        $minutes_ago = floor(($currentTimestamp - $time) / 60);
                                        // $minutes_ago = floor((time() - $time) / 60) + 360;
                                        $hours_ago = floor($minutes_ago / 60);
                                        $days_ago = floor($hours_ago / 24);

                                        ?>
                                        <p class="text-muted">
                                            <small>
                                                <?php
                                                if ($minutes_ago < 60) {
                                                    echo $minutes_ago . " minutes ago";
                                                } else {
                                                    if ($hours_ago < 24) {
                                                        echo $hours_ago . " hours ago";
                                                    } else {
                                                        echo $days_ago . " days ago";
                                                    }
                                                }
                                                ?>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"
                                        style="border:0;background-color:#fff;margin-left:360px;">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <form
                                            action="../Controller/NotificationController.php?notif_id=<?php echo $notification['id'] ?>"
                                            method="POST">
                                            <input type="submit" name="delete" class="dropdown-item" value="Delete"
                                                style="font-size: 1.3rem;">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                </div>
                <!-- <div class="text-center">
                    <a href="#!" class="dark-link">Load more activity</a>
                </div> -->


            </div>

        </main>

        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
</body>

</html>
