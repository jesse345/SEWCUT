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
    <?php include("../layouts/head.layout.php") ?>
    <title>My Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
    }

    .rating > input {
        display: none;
    }

    .rating > label {
        position: relative;
        width: 1em;
        font-size: 3rem;
        color: #007bff;
        cursor: pointer;
    }

    .rating > label::before {
        content: "\2605";
        position: absolute;
        opacity: 0;
    }

    .rating > label:hover:before,
    .rating > label:hover ~ label:before {
        opacity: 1 !important;
    }

    .rating > input:checked ~ label:before {
        opacity: 1;
    }

    .rating:hover > input:checked ~ label:before {
        opacity: 0.4;
    }
    .ui-w-40 {
        width: 40px !important;
        height: auto;
    }

    .ui-product-color {
        display: inline-block;
        overflow: hidden;
        margin: 0.144em;
        width: 0.875rem;
        height: 0.875rem;
        border-radius: 10rem;
        -webkit-box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
        vertical-align: middle;
    }
</style>
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
                    <li class="breadcrumb-item active" aria-current="page">My Purchase</li>
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
                                        <a href="myPurchase.php" class="nav-link active">My Purchase</a>
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
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Reference Order</th>
                                            <th>Status</th>
                                            <th>Total Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        $a = getOrder('orders', $_SESSION['id']);
                                        while ($buyer = mysqli_fetch_assoc($a)):
                                            $productDetails = mysqli_fetch_assoc(displayDetails('product_details', 'id', $buyer['product_id']));
                                            $cart = mysqli_fetch_assoc(displayDetails('carts', 'id', $buyer['cart_id']));
                                            $order_payment = mysqli_fetch_assoc(getrecord('order_payments','order_id',$buyer['id']));
                                            $count++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $count ?>
                                                </td>
                                                <td>
                                                    <?= $productDetails['product_name'] ?>
                                                </td>
                                                <td>
                                                    <?= $buyer['reference_order'] ?>
                                                </td>
                                                <td>
                                                    <?php if($buyer['status'] == 'DisApprove'){ ?>
                                                    <button class="btn btn-danger">
                                                        <?= $buyer['status'] ?>
                                                    </button>
                                                    <?php }else{ ?>
                                                        <button class="btn btn-info">
                                                            <?= $buyer['status'] ?>
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?= $cart['total'] ?>
                                                </td>
                                                <td>
                                                    <form action="../Controller/orderController.php" method="POST">
                                                        <a href="#viewmore-Modal<?php echo $buyer['id'] ?>"
                                                            data-toggle="modal" class="btn btn-success">View More</a>
                                                        <a href="chat.php?user=<?php echo $buyer['seller_id']?>" class="btn btn-primary">Chat Seller</a>
                                                        <input type="hidden" value="<?php echo $buyer['id'] ?>"
                                                            name="order_id">
                                                        <?php if ($buyer['status'] == 'Pending') { ?>
                                                            <button type="submit" name="CANCELORDER" class="btn btn-danger">Cancel Order</button>
                                                        <?php } elseif ($buyer['status'] == 'DisApprove') { ?>
                                                            <button type="submit" name="DELETEORDER" class="btn btn-danger">Delete Order</button>
                                                        <?php } elseif ($buyer['status'] == 'Shipped') { ?>
                                                            <button type="submit" name="RECEIVED" class="btn btn-warning">Receive Product</button>
                                                        <?php } elseif ($buyer['status'] == 'Received') { ?>
                                                            <button type="button" href="#rate-Modal<?php echo $buyer['id'] ?>"
                                                            data-toggle="modal" class="btn btn-warning">
                                                                    <?php
                                                                        $check = mysqli_fetch_assoc(userProductReviews($_SESSION['id'], $buyer['product_id'],$buyer['id']));

                                                                        echo $check > 0 ? "View your review" : " Leave Review";
                                                                    ?>
                                                                
                                                            </button>
                                                        <?php } ?>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- VIEW MORE MODAL -->
                                            <div class="modal fade" id="viewmore-Modal<?php echo $buyer['id'] ?>"
                                                tabindex="-1" role="dialog" aria-hidden="true">
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
                                                            <?php if($order_payment['receipt_image'] != ''){?>
                                                                <label>PROOF OF PAYMENT</label>
                                                                <img src="<?=$order_payment['receipt_image']?>" alt="" style="width:80%;height:250px;">
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
                                            <div class="modal fade" id="rate-Modal<?php echo $buyer['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content p-5">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?php echo $productDetails['product_name'] . " Product Review" ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="../Controller/FeedbackController.php?product_id=<?php echo $buyer['product_id'] ?>" method="POST">
                                                                <input type="hidden" name="order_id" value="<?=$buyer['id']?>">
                                                                <div class="form-group">
                                                                    <label for="rating">Rate the product *</label>
                                                                    <div class="d-flex">
                                                                        <div class="text-primary rating">

                                                                            
                                                                            <?php
                                                                            
                                                                            if ($check > 0) {
                                                                                for ($j = 0; $j < $check['rate']; $j++) {
                                                                                ?>
                                                                                    <i class="fa fa-star-o" style="font-size:24px"></i>
                                                                                <?php }
                                                                                
                                                                            } else {
                                                                                ?>
                                                                                <input type="radio" name="rating" value="5" id="5" required>
                                                                                <label for="5">☆</label>
                                                                                <input type="radio" name="rating" value="4" id="4" required>
                                                                                <label for="4">☆</label>
                                                                                <input type="radio" name="rating" value="3" id="3" required>
                                                                                <label for="3">☆</label>
                                                                                <input type="radio" name="rating" value="2" id="2" required>
                                                                                <label for="2">☆</label>
                                                                                <input type="radio" name="rating" value="1" id="1" required>
                                                                                <label for="1">☆</label>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="message">Your Review *</label>
                                                                    <?php
                                                                    if ($check > 0) {
                                                                    ?>
                                                                        <textarea id="message" cols="30" rows="5" class="form-control" name="feedback" required disabled><?php echo $check['description'] ?></textarea>
                                                                    <?php } else { ?>
                                                                        <textarea id="message" cols="30" rows="5" class="form-control" name="feedback" required></textarea>

                                                                    <?php } ?>
                                                                </div>
                                                                <div class="form-group mb-0">
                                                                    <?php
                                                                    if ($check <= 0) {
                                                                    ?>
                                                                        <input type="submit" name="REVIEW" value="Leave Your Review" class="btn btn-info px-3 float-right">
                                                                    <?php } ?>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
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
</body>

</html>
