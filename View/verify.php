<?php
include("../Model/db.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.layout.php")?>
    <title>My Product</title>
</head>
<body>
    <?php 
    $user = mysqli_fetch_assoc(getrecord('users','id',$_SESSION['id']));
    $userdetails = mysqli_fetch_assoc(getrecord('user_details','id',$_SESSION['id']));
    // if($user['isVerify'] == "Yes"){
    //     header("location:homepage.php");
    // }

    ?>
    <div class="page-wrapper">
        <header class="header header-6">
            <div class="header-bottom sticky-header">
                <div class="container">
                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            <li class="megamenu-containere">
                                <a>Hello <?php echo $userdetails['firstname']. ' ' . $userdetails['lastname'] ?></a>
                            </li>
                            <li class="float-right" style="position: absolute;right: 0%;">
                                <form action="../Controller/userController.php" method="POST">
                                    <a><button type="submit" name="LOGOUT" style="border:none;background-color:transparent;color:white">Logout</button></a>
                                </form>
                            </li>
                        </ul><!-- End .menu -->
                    </nav><!-- End .main-nav -->
                </div><!-- End .container -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->
         <main class="main">
                <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                    <div class="container">
                        <div class="form-box">
                            <div class="tab-pane fade show active" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
                                <p style="font-size:18px;">We hate to be a bother, but we need to do<br> our due
                                    diligence to keep your account safe.<br>
                                    Please enter the code we've just sent to <br><u><?php echo $user['email'] ?> </u>
                                    below to complete your register</p><br><br>
                                <form action="../Controller/verifyController.php" method="POST">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="code" style="border: 1px solid #000;" placeholder="Enter Verification code " required>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2" name="VERIFY">
                                            <span>Verify</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </form>
                                <form action="../Controller/userController.php" method="POST">
                                    <div class="text-right">
                                        <button type="submit" name="RESENDCODE" class="btn btn-link border-0"><u>Resend Code</u></button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- End .form-box -->
                    </div><!-- End .container -->
                </div><!-- End .login-page section-bg -->
            </main><!-- End .main -->
    </div>
     <?php 
        include("../layouts/jsfile.layout.php");
        include("toastr.php");
    ?>
</body>
</html>