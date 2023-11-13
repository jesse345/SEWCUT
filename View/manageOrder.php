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
    <style>
        .btn {
            min-width: 100px;
        }
    </style>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <div class="container mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Order</li>
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
                                        <a href="manageOrder.php" class="nav-link active">Orders</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="myPurchase.php" class="nav-link">My Purchase</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="myShop.php" class="nav-link">My shop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="mySubscription.php" class="nav-link">Manage Subscription</a>
                                    </li>
                                </ul>
                            </aside>
                            <div class="col-10">
                                <table class="table table-hover text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Order By</th>
                                            <th>Reference Order</th>
                                            <th>Product Name</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $b = getOrderSeller('orders', $_SESSION['id']);
                                        $totalIncome = 0;
                                        while ($c = mysqli_fetch_assoc($b)):
                                            $orderby = mysqli_fetch_assoc(getrecord('user_details', 'id', $c['user_id']));
                                            $order_payments = mysqli_fetch_assoc(getrecord('order_payments', 'order_id', $c['id']));
                                            $productDetails = mysqli_fetch_assoc(displayDetails('product_details', 'id', $c['product_id']));
                                            $cart = mysqli_fetch_assoc(displayDetails('carts', 'id', $c['cart_id']));
                                            $shippingInfo = mysqli_fetch_assoc(getrecord('shipping_info', 'user_id', $c['user_id']));
                                            $count++;
                                            if($c['status'] == 'Received'){
                                                $totalIncome += $cart['total'];
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $c['id'] ?>
                                                </td>
                                                <td>
                                                    <?= ucfirst($orderby['firstname']) . ' ' . ucfirst($orderby['lastname']) ?>
                                                </td>
                                                <td>
                                                    <?= $c['reference_order'] ?>
                                                </td>
                                                <td>
                                                    <?= $productDetails['product_name'] ?>
                                                </td>
                                                <td>
                                                    <?= number_format($cart['total'], 2) ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning"><?= $c['status'] ?></button>
                                                </td>
                                                <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        More Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="btn btn-info dropdown-item" href="#viewmore-Modal<?php echo $c['id'] ?>"
                                                        data-toggle="modal">View More
                                                        </a>
                                                            <a href="chat.php?user=<?php echo $c['user_id']?>" class="btn dropdown-item">Chat Seller</a>
                                                        <?php if($c['status'] != 'Approve' && $c['status'] != 'Shipped' && $c['status'] != 'Received'){?>
                                                            <form action="../Controller/orderController.php" method="POST">
                                                                <input type="hidden" name="order_id" value="<?php echo $c['id'] ?>">
                                                                <button class="btn btn-success dropdown-item" id="btn_Approve" name="APPROVE">Approve</button>
                                                            </form>
                                                            <form action="../Controller/orderController.php" method="POST">
                                                                <input type="hidden" name="order_id" value="<?php echo $c['id'] ?>">
                                                                <button type="submit" name="DISAPPROVED" class="btn btn-danger btn_Disapprove dropdown-item" data-id="<?php echo $c['id'] ?>" name="DISAPPROVE">Disapprove</button>
                                                            </form>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php if($c['status'] == 'Approve'){?>
                                                    <form action="../Controller/orderController.php" method="POST">
                                                        <input type="hidden" name="order_id" value="<?php echo $c['id'] ?>">
                                                        <button class="btn btn-success mt-1" name="SHIP_PRODUCT">Ship Product</button>
                                                    </form>  
                                                <?php } ?>
                                                </td>
                                            </tr>
                                            <!-- VIEW MORE MODAL -->
                                            <div class="modal fade" id="viewmore-Modal<?php echo $c['id'] ?>" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog custom-modal add-modal" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <p>View More Details</p>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true"><i class="icon-close"></i></span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="padding:30px;">
                                                            <div class="form-group">
                                                                <label>Product Name</label>
                                                                <input type="text" class="form-control"
                                                                    value="<?= $productDetails['product_name'] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Quantity</label>
                                                                <input type="text" class="form-control"
                                                                    value="<?= $cart['quantity'] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Product Size</label>
                                                                <input type="text" class="form-control"
                                                                    value="<?= $cart['size'] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Product Color</label>
                                                                <input type="text" class="form-control"
                                                                    value="<?= $cart['color'] ?>" readonly>
                                                            </div>
                                                            <hr>
                                                            <center>
                                                                <b>Shipping Information</b>
                                                            </center>
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control"
                                                                    value="<?= $shippingInfo['name'] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Contact Number</label>
                                                                <input type="text" class="form-control"
                                                                    value="<?= $shippingInfo['contact'] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <input type="text" class="form-control"
                                                                    value="<?= $shippingInfo['address'] ?>" readonly>
                                                            </div>
                                                            <hr>
                                                            <center>
                                                                <b>PROOF OF PAYMENT</b>
                                                            </center>
                                                            <?php if($order_payments['receipt_image'] != ''){?>
                                                                <img src="<?=$order_payments['receipt_image']?>" alt="" style="width:80%;height:250px;">
                                                            <?php } ?>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger products"
                                                                data-dismiss="modal" aria-label="Close">
                                                                Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td>Total Income:</td>
                                            <td>
                                                <b>P <?=$totalIncome?></b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php 
        include("../layouts/jsfile.layout.php");
        include("toastr.php");
    ?>
    <!-- <script>
        $(".btn_Disapprove").click(function () {
            var order_id = $(this).data("id");
            
            $.ajax({
                type: "POST",
                url: "../Controller/orderController.php",
                data: {
                    DISAPPROVED: true,
                    order_id: order_id
                },
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle any AJAX errors here
                    console.error("AJAX error:", error);
                }
            });
			
		});
    </script> -->
</body>

</html>
