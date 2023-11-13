<?php
include("../Model/db.php");
session_start();
$address = sizeOrColor('address');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../layouts/head.layout.php") ?>
    <title>Homepage</title>
    <style>
        .center-container {
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            height: 50vh;
            /* Set the container's height to 100% of the viewport height for vertical centering */
        }

        /* Additional styling for the form (optional) */
        .center-container form {
            text-align: center;
            /* Center form elements horizontally */
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
            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
                style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="tab-pane fade show active" id="register-2" role="tabpanel"
                            aria-labelledby="register-tab-2">
                            <h3>Register</h3>
                            <form action="../Controller/userController.php" method="POST">
                                <div class="form-group">
                                    <label>Firstname</label>
                                    <input type="text" class="form-control" name="firstname" required>
                                </div>
                                <div class="form-group">
                                    <label>Lastname</label>
                                    <input type="text" class="form-control" name="lastname" required>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label>Retype Password</label>
                                    <input type="password" class="form-control" name="repassword" required>
                                </div>
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" name="contact_number" required>
                                </div>
                                <div class="form-group">
                                     <label>Address</label>
                                    <select name="address" class="form-control" required>
                                        <option value="" selected>Select Address</option>
                                        <?php while($add = mysqli_fetch_assoc($address)): ?>
                                        <option value="<?php echo $add['id']?>"><?php echo $add['address']?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <!-- <label>Address</label>
                                    <input type="text" class="form-control" name="address"> -->
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2" name="register">
                                        <span>SIGN UP</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>

                                    <div class="custom-control custom-checkbox" style="margin-left: 11px;">
                                        <input type="checkbox" class="custom-control-input" id="register-policy"
                                            required>
                                        <label class="custom-control-label" for="register-policy">I agree to the<a
                                                href="#"> Privacy Policy</a></label>
                                    </div><!-- End .custom-checkbox -->
                                </div><!-- End .form-footer -->
                            </form>
                        </div><!-- .End .tab-pane -->
                    </div><!-- End .form-box -->
                </div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
        </main><!-- End .main -->
        <?php include("../layouts/footer.layout.php") ?>
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
</body>


<!-- molla/index-6.html  22 Nov 2019 09:56:39 GMT -->

</html>
