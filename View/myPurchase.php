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
    .ratedstar{
        color:black;
        font-size:30px;
    }
    .star-group {
        display: grid;
        font-size: clamp(1.5em, 10vw, 5em);
        grid-auto-flow: column;
    }

    /* reset native input styles */
    .star {
        -webkit-appearance: none;
        align-items: center;
        appearance: none;
        cursor: pointer;
        display: grid;
        font: inherit;
        height: 1.15em;
        justify-items: center;
        margin: 0;
        place-content: center;
        position: relative;
        width: 1.15em;
    }

    @media (prefers-reduced-motion: no-preference) {
        .star {
            transition: all 0.25s;
        }

        .star:before,
        .star:after {
            transition: all 0.25s;
        }
    }

    .star:before,
    .star:after {
        color: var(--star-primary-color);
        position: absolute;
    }

    .star:before {
        content: "☆";
    }

    .star:after {
        content: "✦";
        font-size: 25%;
        opacity: 0;
        right: 20%;
        top: 20%;
    }

    /* The checked radio button and each radio button preceding */
    .star:checked:before,
    .star:has(~ .star:checked):before {
        content: "★";
    }

    #two:checked:after,
    .star:has(~ #two:checked):after {
        opacity: 1;
        right: 14%;
        top: 10%;
    }

    #three:checked:before,
    .star:has(~ #three:checked):before {
        transform: var(--enlarge);
    }

    #three:checked:after,
    .star:has(~ #three:checked):after {
        opacity: 1;
        right: 8%;
        top: 2%;
        transform: var(--enlarge);
    }

    #four:checked:before,
    .star:has(~ #four:checked):before {
        text-shadow: 0.05em 0.033em 0px var(--star-secondary-color);
        transform: var(--enlarge);
    }

    #four:checked:after,
    .star:has(~ #four:checked):after {
        opacity: 1;
        right: 8%;
        top: 2%;
        transform: var(--enlarge);
    }

    #five:checked:before,
    .star:has(~ #five:checked):before {
        text-shadow: 0.05em 0.033em 0px var(--star-secondary-color);
        transform: var(--enlarge);
    }

    #five:checked:after,
    .star:has(~ #five:checked):after {
        opacity: 1;
        right: 8%;
        text-shadow: 0.14em 0.075em 0px var(--star-secondary-color);
        top: 2%;
        transform: var(--enlarge);
    }

    .star-group:has(> #five:checked) {
        #one {
            transform: rotate(-15deg);
        }

        #two {
            transform: translateY(-20%) rotate(-7.5deg);
        }

        #three {
            transform: translateY(-30%);
        }

        #four {
            transform: translateY(-20%) rotate(7.5deg);
        }

        #five {
            transform: rotate(15deg);
        }
    }

    .star:focus {
        outline: none;
    }

    .star:focus-visible {
        border-radius: 8px;
        outline: 2px dashed var(--star-primary-color);
        outline-offset: 8px;
        transition: all 0s;
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
                                        <a href="customAndAlter.php" class="nav-link">Custom & Alter Transaction</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="mySubscription.php" class="nav-link">Manage Subscription</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="transactionReport.php" class="nav-link">Transaction Report</a>
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
                                                        <button class="btn btn-warning">
                                                            <?= $buyer['status'] ?>
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?= number_format($cart['total'],2) ?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            More Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <form action="../Controller/orderController.php" method="POST">
                                                                <a href="#viewmore-Modal<?php echo $buyer['id'] ?>"
                                                                    data-toggle="modal" class="btn btn-success dropdown-item">View More</a>
                                                                <a href="chat.php?user=<?php echo $buyer['seller_id']?>" class="btn dropdown-item">Chat</a>
                                                                <input type="hidden" value="<?php echo $buyer['id'] ?>"
                                                                    name="order_id">
                                                                <?php if ($buyer['status'] == 'Pending') { ?>
                                                                    <button type="submit" name="CANCELORDER" class="btn btn-danger dropdown-item">Cancel Order</button>
                                                                <?php } elseif ($buyer['status'] == 'DisApprove') { ?>
                                                                    <button type="submit" name="DELETEORDER" class="btn btn-danger dropdown-item">Delete Order</button>
                                                                <?php } elseif ($buyer['status'] == 'Shipped') { ?>
                                                                    <button type="submit" name="RECEIVED" class="btn btn-warning dropdown-item">Receive Product</button>
                                                                <?php } elseif ($buyer['status'] == 'Received') { ?>
                                                                    <button type="button" href="#rate-Modal<?php echo $buyer['id'] ?>"
                                                                    data-toggle="modal" class="btn btn-warning dropdown-item">
                                                                            <?php
                                                                                $check = mysqli_fetch_assoc(userProductReviews($_SESSION['id'], $buyer['product_id'],$buyer['id']));
                                                                                echo $check > 0 ? "View your review" : " Leave Review";
                                                                            ?>
                                                                    </button>
                                                                    <a href="#report-Modal<?php echo $buyer['id'] ?>"
                                                                    data-toggle="modal"  class="btn btn-warning dropdown-item">Report</a>
                                                                <?php } ?>
                                                            </form>
                                                        </div>
                                                    </div>

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
                                                                    
                                                                     <?php
                                                                    if ($check > 0) { ?>
                                                                        <label for="rating">Product Rated</label><br>
                                                                        <?php
                                                                        for ($j = 0; $j <  $check['rate']; $j++) {
                                                                        ?>
                                                                            <span class="fa fa-star checked ratedstar"></span>
                                                                        <?php }
                                                                    } else { ?>
                                                                        <label for="rating">Rate the product *</label>
                                                                        <div class="star-group" style="margin-top: 36px;">
                                                                            <input type="radio" class="star" id="one" name="rating" value="1" checked>
                                                                            <input type="radio" class="star" id="two" name="rating" value="2" >
                                                                            <input type="radio" class="star" id="three" name="rating" value="3" >
                                                                            <input type="radio" class="star" id="four" name="rating" value="4" >
                                                                            <input type="radio" class="star" id="five" name="rating" value="5" >
                                                                        </div>
                                                                    <?php } ?>
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
                                            <div class="modal fade" id="report-Modal<?php echo $buyer['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content p-5">
                                                        <form action="../Controller/orderController.php" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="seller_id" value="<?=$buyer['seller_id']?>">
                                                                <label for="">Reason</label>
                                                                <textarea name="reason" class="form-control" cols="30" rows="10"></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger products"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    Discard
                                                                </button>
                                                                <button type="submit" name="REPORT" class="btn btn-info">Report</button>
                                                            </div>
                                                        </form>
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
