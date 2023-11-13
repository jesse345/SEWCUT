<?php
include("../Model/db.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <?php include("../layouts/head.layout.php")?>
    <title>Homepage</title>
    <style>
    .center-container {
        display: flex;
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        height: 50vh; /* Set the container's height to 100% of the viewport height for vertical centering */
    }

    /* Additional styling for the form (optional) */
    .center-container form {
        text-align: center; /* Center form elements horizontally */
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout1.php"); ?>
         <main class="main">
                <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                    <div class="container">
                        <div class="form-box">
                            <div class="tab-pane fade show active" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
                                <h3>Login</h3>
                                <form action="../Controller/userController.php" method="POST">
                                    <div class="form-group">
                                        <label>Email Addres or Username</label>
                                        <input type="text" class="form-control" name="singin-username" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="singin-password" required>
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2" name="LOGIN">
                                            <span>LOG IN</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- End .form-box -->
                    </div><!-- End .container -->
                </div><!-- End .login-page section-bg -->
            </main><!-- End .main -->
        <?php include("../layouts/footer.layout.php")?>
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>


    <?php 
        include("../layouts/jsfile.layout.php");
        include("toastr.php");
    ?>
</body>


<!-- molla/index-6.html  22 Nov 2019 09:56:39 GMT -->
</html>