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
                                        <a href="myAccount.php" class="nav-link">My Account</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="gcash_info.php" class="nav-link active">Gcash Info</a>
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
                                <form action="../Controller/userController.php" method="POST">
                                    <div class="card mx-auto mt-5" style="width:50%">
                                        <div class="card-header">Gcash Info</div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Gcash Name</label>
                                                <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                                                <input type="text" class="form-control" name="gcash_name"
                                                    value="<?php echo $user['gcash_name'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Gcash Number</label>
                                                <input type="text" class="form-control" name="gcash_number"
                                                    value="<?php echo $user['gcash_number'] ?>">
                                            </div>
                                            <button type="submit" class="btn btn-outline-dark"
                                                name="UPDATEGCASH">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
</body>

</html>
