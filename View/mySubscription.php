<?php
include("../Model/db.php");
session_start();
error_reporting(0);

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php include("../layouts/head.layout.php") ?>
    <link rel="stylesheet" href="../assets/css/subscription.css">
    <link rel="stylesheet" href="../assets/css/myProduct.css">
    <style>
        .btn {
            min-width: 100px;
        }

        input[type=text] {
            border: 1px solid #000;
            color: #000;
        }
        .countdown-container {
            display: flex;
            flex-wrap: row;
            margin: 0;
        }

        .countdown {
            display: flex;
        }

        .countdown .day,
        .countdown .hour,
        .countdown .min,
        .countdown .sec {
            color: #000;
            padding: 1vw 3vw;
            text-align: center;
        }

        .countdown .day .num,
        .countdown .hour .num,
        .countdown .min .num,
        .countdown .sec .num {
            display: block;
            font-size: 8vw;
            line-height: 1em;
        }

        .countdown .day .word,
        .countdown .hour .word,
        .countdown .min .word,
        .countdown .sec .word {
            display: block;
            font-size: 2vw;
            color: #8a99ab;
        }

        p {
            color: black;
        }

    </style>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $admin = mysqli_fetch_assoc(getallrecord('admin'));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <div class="container mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Subscription</li>
                </ol>
            </nav>
        </div>
        <main class="main mt-3">
            <div class="page-content">
                <div class="dashboard">
                    <div class="container-fluid">
                        <div class="row">
                            <aside class="col-md-2 col-lg-2" style="border-right: 1px solid #ebebeb;">
                                <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist"
                                    style="height:600px;">
                                    <li class="nav-item">
                                        <a href="myAccount.php" class="nav-link">My Account</a>
                                    </li>
                                     <li class="nav-item">
                                        <a href="gcash_info.php" class="nav-link">Gcash Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="myProduct.php" class="nav-link">My Product</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="manageOrder.php" class="nav-link">Orders</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="myPurchase.php" class="nav-link">My Purchase</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="myShop.php" class="nav-link">My shop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="customAndAlter.php" class="nav-link">Custom & Alter Transaction</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="mySubscription.php" class="nav-link active">Manage Subscription</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="transactionReport.php" class="nav-link">Transaction Report</a>
                                    </li>
                                </ul>
                            </aside>
                            <?php 
                            $currentDateTime = time();

                            $subscription = ExtendSubscription($_SESSION['id']);
                            $userSubscribed = isUserSubscribe($_SESSION['id']);
                            $subscriptionData = mysqli_fetch_assoc($subscription);
                            $dateExpire = strtotime($subscriptionData['date_expire']);
                            $timeDifference = $dateExpire - $currentDateTime;
                            
                            if(mysqli_num_rows($subscription) > 0){ 
                                ?>
                                <div class="col-10">
                                    <?php
                                    if(mysqli_num_rows($userSubscribed) > 0){
                                        if ($subscriptionData['date_expire'] != '0000-00-00 00:00:00') {
                                            ?>
                                            <div class="countdown-container">
                                                <a style="position:absolute;right:0;" href="#extend_modal" data-toggle="modal" class="btn btn-info">Extend Subscription</a>
                                                <div class="wrapper">
                                                    <h5>Subscriptions Durations:</h5>
                                                    <div class="countdown" data-date="<?php echo date('Y-m-d H:i:s', strtotime($subscriptionData['date_expire'])) ?>">
                                                        <div class="day">
                                                            <span class="num"></span><span class="word">days</span>
                                                        </div>
                                                        <div class="hour">
                                                            <span class="num"></span><span class="word">hours</span>
                                                        </div>
                                                        <div class="min">
                                                            <span class="num"></span><span class="word">minutes</span>
                                                        </div>
                                                        <div class="sec">
                                                            <span class="num"></span><span class="word">seconds</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        <?php } ?>
                                    <?php }else{ ?>   
                                         <a href="subscription.php"><button class="btn btn-info">Subscribe now</button></a>
                                    <?php } ?>         
                                    <table class="table table-hover text-center mt-5">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>TYPE</th>
                                                <th>Amount</th>
                                                <th>Reference Number</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $data = getrecord('subscription','user_id',$_SESSION['id']);
                                            while($sub = mysqli_fetch_assoc($data)):?>
                                            <tr>
                                                <td><?=$sub['id']?></td>
                                                <td><?=$sub['type']?></td>
                                                <td><?=$sub['amount']?></td>
                                                <td><?=$sub['reference_number']?></td>
                                                <td><button class="btn btn-success"><?=$sub['status']?></button></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php }else{ ?>
                                <a href="subscription.php"><button class="btn btn-info mx-5">Subscribe now</button></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <div class="modal fade" id="extend_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog custom-modal add-modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p>Extend Subscritpion</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php
                        $user = subscriptionForFree($_SESSION['id']);
                        if (mysqli_num_rows($user) < 1) { ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="pricingTable green">
                                    <div class="pricingTable-header">
                                        <h3>Free Trial</h3>
                                    </div>
                                    <div class="pricing-plans">
                                        <span class="price-value"></i><span>Free</span></span>

                                    </div>
                                    <div class="pricingContent">
                                        <ul>
                                            <li><b>1 month Duration</b> </li>
                                        </ul>
                                    </div>
                                    <!-- CONTENT BOX-->
                                    <div class="pricingTable-sign-up">
                                        <button type="button" href="#FreeSubscribe" data-toggle="modal"
                                            class="btn btn-success">Use</button>
                                    </div>
                                    <!-- BUTTON BOX-->
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="pricingTable purple">
                                    <div class="pricingTable-header">
                                        <h3>Standard</h3>

                                    </div>
                                    <div class="pricing-plans">
                                        <span class="price-value"></i><span>₱199.00</span></span>

                                    </div>
                                    <div class="pricingContent">
                                        <ul>
                                            <li><b>3 months Duration </b> </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="pricingTable-sign-up">
                                        <button type="button" id="btn_Subscribe" data-value="199" data-type="1"
                                            class="btn btn-success">Extend</button>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="pricingTable yellow">
                                    <div class="pricingTable-header">
                                        <h3>Advance</h3>

                                    </div>
                                    <div class="pricing-plans">
                                        <span class="price-value"></i><span>₱399.00</span></span>
                                    </div>
                                    <div class="pricingContent">
                                        <ul>
                                            <li><b>6 months Duration </b> </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="pricingTable-sign-up">
                                        <button type="button" id="btn_Subscribe2" data-value="399" data-type="2"
                                            class="btn btn-success">Extend</button>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6"> 
                                <div class="pricingTable purple">
                                    <div class="pricingTable-header">
                                        <h3>Premium</h3>
                                    </div>
                                    <div class="pricing-plans">
                                        <span class="price-value"></i><span>₱699.00</span></span>

                                    </div>
                                    <div class="pricingContent">
                                        <ul>
                                            <li><b>1 year Duration </b> </li>
                                        </ul>
                                    </div>
                                    <!-- CONTENT BOX-->
                                    <div class="pricingTable-sign-up">
                                        <button type="button" id="btn_Subscribe3" data-value="699" data-type="3"
                                            class="btn btn-success">Extend</a>
                                    </div>
                                    <!-- BUTTON BOX-->
                                </div>
                            </div>
                        <?php } else{?>
                            <div class="col-md-4 col-sm-6">
                                <div class="pricingTable purple">
                                    <div class="pricingTable-header">
                                        <h3>Standard</h3>

                                    </div>
                                    <div class="pricing-plans">
                                        <span class="price-value"></i><span>₱199.00</span></span>

                                    </div>
                                    <div class="pricingContent">
                                        <ul>
                                            <li><b>3 months Duration </b> </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="pricingTable-sign-up">
                                        <button type="button" id="btn_Subscribe" data-value="199" data-type="1"
                                            class="btn btn-success">Extend</button>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="pricingTable yellow">
                                    <div class="pricingTable-header">
                                        <h3>Advance</h3>

                                    </div>
                                    <div class="pricing-plans">
                                        <span class="price-value"></i><span>₱399.00</span></span>
                                    </div>
                                    <div class="pricingContent">
                                        <ul>
                                            <li><b>6 months Duration </b> </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="pricingTable-sign-up">
                                        <button type="button" id="btn_Subscribe2" data-value="399" data-type="2"
                                            class="btn btn-success">Extend</button>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6"> 
                                <div class="pricingTable purple">
                                    <div class="pricingTable-header">
                                        <h3>Premium</h3>
                                    </div>
                                    <div class="pricing-plans">
                                        <span class="price-value"></i><span>₱699.00</span></span>

                                    </div>
                                    <div class="pricingContent">
                                        <ul>
                                            <li><b>1 year Duration </b> </li>
                                        </ul>
                                    </div>
                                    <!-- CONTENT BOX-->
                                    <div class="pricingTable-sign-up">
                                        <button type="button" id="btn_Subscribe3" data-value="699" data-type="3"
                                            class="btn btn-success">Extend</a>
                                    </div>
                                    <!-- BUTTON BOX-->
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="FreeSubscribe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="../Controller/subscriptionController.php" method="POST">
                    <div class="modal-body">
                        <center>
                            <p style="font-size: 15px; font-weight: 500;margin-top:50px;">Are you sure you want to use your free trial ?</p>
                        </center>
                    </div>
                    <div class="modal-footer footer1 mt-5">
                        <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                            No
                        </button>
                        <button type="submit" class="btn btn-dark products" name="FREETRIAL">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-payment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Extend Subscription Using Gcash Payment</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="../Controller/subscriptionController.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div>
                            <img src="https://mcdn.pybydl.com/lco/assets/payment/logo/gcash-353da48c3e4788d6e671a2aa05f783ea08cb6f8547713212ca7d6daf636e959c.svg"
                                class="mx-auto d-block" style="width:50%;height:150px;" alt="">
                        </div>
                        <div style="margin-left:40px;margin-right:40px;">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Gcash Name</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    value="<?= $admin['gcash_name'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gcash Number</label>
                                <input type="text" class="form-control" value="<?= $admin['gcash_number'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <input type="text" class="form-control" name="amount" id="amount" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Upload Receipt</label><br>
                                <input type="file" name="image" id="image" required>
                            </div>
                            <img id="image-preview" src="" alt="Image Preview"
                                style="max-width: 100%; max-height: 200px;display:none;">

                            <div class="form-group">
                                <label class="form-label">Reference No</label>
                                <input type="text" class="form-control" name="ref" id="reference-no"
                                    placeholder="Enter Reference No" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="EXTEND" id="subscribe">Extend</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>

</body>
<script>
    
    const countdownContainer = document.querySelector('.countdown');

    function updateCountdown() {
        const targetDate = new Date(countdownContainer.getAttribute("data-date"));
        const currentDate = new Date();
        const timeDifference = targetDate - currentDate;

        if (timeDifference <= 0) {
            // Timer has expired, you can handle this case as needed
            clearInterval(countdownInterval); // Stop the timer
            countdownContainer.innerHTML = "Timer expired!";
            return;
        }

        const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

        countdownContainer.querySelector(".day .num").textContent = days;
        countdownContainer.querySelector(".hour .num").textContent = hours;
        countdownContainer.querySelector(".min .num").textContent = minutes;
        countdownContainer.querySelector(".sec .num").textContent = seconds;
    }

    const countdownInterval = setInterval(updateCountdown, 1000); // Update every 1 second

    // Initial call to set up the countdown
    updateCountdown();
</script>
<script>
    autoUpdateSubscribe()
    
    $(document).ready(function () {
        $("#btn_Subscribe ,#btn_Subscribe2 ,#btn_Subscribe3").on("click", function () {
            var dataValue = $(this).data("value");
            var dataType = $(this).data("type");

            $("#amount").val(dataValue);
            $("#type").val(dataType);
            $("#modal-payment").modal("show");
        });
    });

    function autoUpdateSubscribe(){
        $.ajax({
            type: "POST",
            url: "../Controller/subscriptionController.php",
            data: {
                AUTOMATICUPDATE: true, 
            },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }
</script>

</html>
