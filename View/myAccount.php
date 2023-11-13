<?php
include("../Model/db.php");
session_start();
$address = sizeOrColor('address');
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../layouts/head.layout.php") ?>
    <title>My Account</title>
    <link rel="stylesheet" href="../assets/css/myAccount.css">
</head>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $users = mysqli_fetch_assoc(getrecord('users', 'id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main mt-3">
            <div class="page-content">
                <div class="dashboard">
                    <div class="container-fluid">
                        <div class="row">
                            <aside class="col-md-2 col-lg-2" style="border-right: 1px solid #ebebeb;">
                                <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist"
                                    style="height:600px;">
                                    <li class="nav-item">
                                        <a href="myAccount.php" class="nav-link active">My Account</a>
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
                                        <a href="myShop.php" class="nav-link">My Shop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="mySubscription.php" class="nav-link">Manage Subscription</a>
                                    </li>
                                </ul>
                            </aside><!-- End .col-lg-3 -->

                            <div class="col-10">
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form action="../Controller/userController.php" method="POST"
                                                enctype="multipart/form-data">
                                                <div class="card">
                                                    <div class="card-header">Profile Picture</div>
                                                    <div class="card-body">
                                                        <div class="form-element">
                                                            <input type="file" id="file-5" name="image" accept="image/*"
                                                                required>
                                                            <label for="file-5" id="file-5-preview">
                                                                <img src="<?php echo $user['user_img'] ?>"
                                                                    class="img-responsive">
                                                                <div>
                                                                    <span>+</span>
                                                                </div>
                                                                <button type="submit" class="btn btn-outline-dark"
                                                                    name="UPDATEPROFILE"
                                                                    style="margin-top: 10px;margin-left: 75px;">Save
                                                                    Changes</button>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        </form>
                                        <div class="col-md-8">
                                            <form action="../Controller/userController.php" method="POST">
                                                <div class="card">
                                                    <div class="card-header">Account Details</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="">Firstname</label>
                                                                    <input type="text" class="form-control"
                                                                        name="firstname"
                                                                        value="<?php echo $user['firstname'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="">Lastname</label>
                                                                    <input type="text" class="form-control"
                                                                        name="lastname"
                                                                        value="<?php echo $user['lastname'] ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Contact Number</label>
                                                            <input type="text" class="form-control" name="contact"
                                                                value="<?php echo $user['contact_number'] ?>">
                                                        </div>
                                                        <?php $saveAddress = mysqli_fetch_assoc(getrecord('address', 'id', $user['address']))?>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <select name="address" class="form-control" required>
                                                                        <option value="<?php echo $user['address'] ?>" selected><?=$saveAddress['address']?></option>
                                                                        <?php while($add = mysqli_fetch_assoc($address)): ?>
                                                                        <option value="<?php echo $add['id']?>"><?php echo $add['address']?></option>
                                                                        <?php endwhile; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="text" class="form-control" name="email"
                                                                        id="emailInput"
                                                                        value="<?php echo $users['email'] ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-8">
                                                                <div class="form-group">
                                                                    <label>Username</label>
                                                                    <input type="text" class="form-control"
                                                                        name="username"
                                                                        value="<?php echo $users['username'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label>Password</label>
                                                                    <a href="#signin-modal" data-toggle="modal"
                                                                        class="btn btn-dark"
                                                                        style="width: 203px;">Change Password</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-outline-dark"
                                                            name="UPDATEUSER">Save Changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .col-lg-9 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <form action="../Controller/userController.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="new_password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-dark" name="CHANGEPASS">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
    <script>
        function previewBeforeUpload(id) {
            document.querySelector("#" + id).addEventListener("change", function (e) {
                if (e.target.files.length == 0) {
                    return;
                }
                let file = e.target.files[0];
                let url = URL.createObjectURL(file);
                document.querySelector("#" + id + "-preview img").src = url;
            });
        }

        previewBeforeUpload("file-5");
    </script>


</body>

</html>
