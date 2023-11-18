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
    <link rel="stylesheet" href="../assets/css/myProduct.css">
    <style>
        .btn {
            min-width: 100px;
        }

        input[type=text] {
            border: 1px solid #000;
            color: #000;
        }
    </style>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $users = mysqli_fetch_assoc(getrecord('users','id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <div class="container mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Shop</li>
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
                                        <a href="myShop.php" class="nav-link active">My shop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="mySubscription.php" class="nav-link">Manage Subscription</a>
                                    </li>
                                </ul>
                            </aside>
                            <div class="col-10">
                                <?php $user1 = getShop($_SESSION['id']);
                                $shop = mysqli_fetch_assoc($user1);
                                if ($user && mysqli_num_rows($user1) == 0) { 
                                    if($users['isSubscribe'] == 'Yes'){
                                        ?>
                                        <a href="#create_shop" data-toggle="modal" class="btn btn-dark">Create Shop</a>
                                    <?php } else { ?>
                                        <a href="subscription.php"  class="btn btn-dark">Create Shop</a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="page-header text-center"
                                        style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                                        <div class="container">
                                            <h1 class="page-title"
                                                style="color:#000;font-size:5rem!important;font-weight:500;">
                                                <?php echo strtoupper($shop['shop_name']); ?><span style="color:#26180b;">
                                                    <?php echo $shop['address']; ?>
                                                </span>
                                            </h1>
                                        </div>
                                    </div>
                                   
                                    <table class="table table-hover text-center mt-5">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>TYPE</th>
                                                <th>STATUS</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>asda</td>
                                                <td>asda</td>
                                                <td>asda</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <div class="modal fade" id="create_shop" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Create Shop</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <form action="../Controller/shopController.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" class="form-control" name="shop_name" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <select name="address" class="form-control" require>
                                <option value="" disable>Select Address</option>
                                <?php $add = getallrecord('address');
                                while ($address = mysqli_fetch_assoc($add)): ?>
                                    <option value="<?php echo $address['id'] ?>">
                                        <?php echo $address['address'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <label for="">Shop Can:</label>
                        <div class="form-group mb-0">
                            <input type="checkbox" id="customize" name="can_customize"> Customize
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="can_alter"> Alter
                        </div>
                    
                        <div class="form-group" id="show_customize">
                        <label for="">Shop Can Customize:</label>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Dresses"> Dresses
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="T-Shirts"> T-Shirts
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Jeans"> Jeans
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Jackets"> Jackets
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Bag"> Bag
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Sportswears"> Sportswears
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Shoes"> Shoes
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Jumpers"> Jumpers
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                        <button type="submit" class="btn btn-dark products" id="add_product_btn"
                            name="CREATESHOP">CREATE SHOP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php 
        include("../layouts/jsfile.layout.php");
        include("toastr.php");
        include('../assets/js/prod.php');
    ?>
    
</body>
<script>
    $(document).ready(function () {
        $("#show_customize").hide()
        $("#customize").change(function () {
            if ($(this).is(":checked")) {
                $("#show_customize").show();
            } else {
                $("#show_customize").hide();
            }
        });
    });
   
    
</script>
</html>
