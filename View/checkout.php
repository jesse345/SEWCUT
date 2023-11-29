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
    <title>My Product</title>
    <style>
        .table.table-summary tbody td {
            border-bottom: none;
            height: 40px;
        }

        .summary-total {
            border-top: .1rem solid #ebebeb;
        }
        .form-control{
            border:1px solid #000;
        }
        .btn {
            min-width: 100px;
        }
    </style>
</head>

<body>
    <?php
    $shipping_info = mysqli_fetch_assoc(getRecentShippingAddress('shipping_info', 'user_id', $_SESSION['id']));
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $seller = mysqli_fetch_assoc(getrecord('user_details', 'id', $_GET['seller']));
    $p = displayDetails('product_details', 'category', 'dress');
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="cart.php">Cart</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="page-content">
                <div class="cart">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9">
                                <table class="table table-cart table-mobile">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subTotal = 0;
                                        $cart = displayEachseller($_SESSION['id'], $_GET['seller']);
                                        $count = 0;
                                        while ($c = mysqli_fetch_assoc($cart)):
                                            $productPrice = getProductPrice($c['product_id'], $c['color'], $c['size']);
                                            $productImages = displayDetails('product_images', 'product_id', $c['product_id']);
                                            $p = mysqli_fetch_assoc($productImages);
                                            $productDetails = mysqli_fetch_assoc(displayDetails('product_details', 'id', $c['product_id']));
                                            $count++;
                                            ?>
                                            <tr>
                                                <td class="product-col">
                                                    <div class="product">
                                                        <figure class="product-media">
                                                            <a href="#productViewMore-Modal<?php echo $c['id'] ?>"
                                                                data-toggle="modal">
                                                                <img src="<?php echo $p['image'] ?>">
                                                            </a>
                                                            <div class="modal fade"
                                                                id="productViewMore-Modal<?php echo $c['id'] ?>"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog custom-modal add-modal"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <div class="card-body">
                                                                                <label>Images and Videos</label><br>
                                                                                <img src="<?php echo $p['image'] ?>"
                                                                                    class="img-responsive">
                                                                                <?php while ($pi = mysqli_fetch_assoc($productImages)): ?>
                                                                                    <?php
                                                                                    $fileExtension = pathinfo($pi['image'], PATHINFO_EXTENSION);

                                                                                    if (in_array($fileExtension, array('jpg', 'jpeg', 'png', 'gif'))):
                                                                                        // Display Image
                                                                                        ?>
                                                                                        <img src="<?php echo $pi['image']; ?>"
                                                                                            class="img-responsive mt-3" alt="Image">
                                                                                    <?php elseif (in_array($fileExtension, array('mp4', 'avi', 'mov'))):
                                                                                        // Display Video
                                                                                        ?>
                                                                                        <video controls class="video-responsive"
                                                                                            style="margin-top:10px;width:523px;">
                                                                                            <source
                                                                                                src="<?php echo $pi['image']; ?>"
                                                                                                type="video/<?php echo $fileExtension; ?>">
                                                                                            <!-- Add more source elements for other video formats if needed -->
                                                                                            Your browser does not support the video
                                                                                            tag.
                                                                                        </video>
                                                                                    <?php endif; ?>
                                                                                <?php endwhile; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-danger products"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                Close
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </figure>

                                                        <h3 class="product-title">
                                                            <a href="#">
                                                                <?= $productDetails['product_name'] ?>
                                                            </a>
                                                        </h3><!-- End .product-title -->
                                                    </div><!-- End .product -->
                                                </td>
                                                <td class="price-col">
                                                    <?= $productPrice['price'] ?>
                                                </td>
                                                <td class="price-quantity">
                                                    <?= $c['quantity'] ?>
                                                </td>
                                                <td>
                                                    <?= $c['total'] ?>
                                                </td>
                                            </tr>
                                            <form action="../Controller/orderController.php" method="POST">
                                                <?php $subTotal += $c['total'] ?>
                                                <input type="hidden" name="seller_id" value="<?= $_GET['seller'] ?>">

                                                <input type="hidden" name="cart_id[]" value="<?= $c['id'] ?>">
                                                <input type="hidden" name="product_id[]" value="<?= $c['product_id'] ?>">
                                            <?php endwhile; ?>
                                            <input type="hidden" name="subTotal" value="<?= $subTotal ?>">
                                    </tbody>
                                </table><!-- End .table table-wishlist -->
                                <div class="cart-bottom">
                                    <a href="cart.php" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i
                                            class="icon-refresh"></i></a>
                                </div><!-- End .cart-bottom -->
                            </div><!-- End .col-lg-9 -->
                            <aside class="col-lg-3">
                                <div class="summary summary-cart" style="margin-top:40px;">
                                    <h3 class="summary-title">Shipping Info</h3>
                                    <div class="form-group">
                                        <label>FullName</label>
                                        <input type="text" class="form-control" name="fullname"
                                            value="<?= ucfirst($shipping_info['name']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" name="contact_number"
                                            value="<?= $shipping_info['contact'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address"
                                            value="<?= $shipping_info['address'] ?>">
                                    </div>
                                    <a href="#ShippingInfo" data-toggle="modal" type="button" class="btn btn-success">
                                        Change Shipping Info
                                    </a>
                                    <hr>
                                    <h3 class="summary-title mt-3">Cart Total</h3>
                                    <form action="../Controller/orderController.php" method="POST">
                                        <table class="table table-summary">
                                            <tbody>
                                                <tr class="summary-shipping-estimate">
                                                    <input type="hidden" class="form-control" name="fullname"
                                                        value="<?= ucfirst($shipping_info['name']) ?>">
                                                    <input type="hidden" class="form-control" name="contact_number"
                                                        value="<?= $shipping_info['contact'] ?>">
                                                    <input type="hidden" class="form-control" name="address"
                                                        value="<?= $shipping_info['address'] ?>">
                                                </tr>
                                                <tr>
                                                    <td>Type of Payment</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Cash On Delivery</td>
                                                    <td><input type="radio" class="payment_type" name="payment-type" value="COD" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Online Payment</td>
                                                    <td><input type="radio" class="payment_type" name="payment-type" value="onlinepayment"
                                                            required></td>
                                                </tr>
                                                <tr class="summary-total">
                                                    <td>Number of Item(s):</td>
                                                    <td>
                                                        <?= $count ?>
                                                    </td>
                                                </tr>
                                                <tr class="summary-total" style="border-top:none">
                                                    <td>Total:</td>
                                                    <td>P
                                                        <?= $subTotal ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block PLACE_ORDER"
                                            name="PLACEORDER">PLACE ORDER
                                        </button>
                                       
                                    </form>
                                </div>    
                            </aside><!-- End .col-lg-3 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php $shipping_info1 = getrecord('shipping_info','user_id',$_SESSION['id'])?>
    <div class="modal fade" id="ShippingInfo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog custom-modal"
            role="document" style="max-width:1000px;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card-body">
                        <?php 
                        $count = 0;
                        while($infos = mysqli_fetch_assoc($shipping_info1)) {
                            ?>
                            <form action="../Controller/orderController.php" method="POST">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="">FullName</label>
                                        <input type="hidden" name="shipping_info_id" value="<?=$infos['id']?>">
                                        <input type="hidden" name="seller_id" value="<?php echo $_GET['seller']?>">
                                        <input type="text" class="form-control" value="<?=$infos['name']?>">
                                    </div>
                                    <div class="col-3">
                                        <label for="">Contact Number</label>
                                        <input type="text" class="form-control" value="<?=$infos['contact']?>">
                                    </div>
                                    <div class="col-3">
                                        <label for="">Address</label>
                                        <input type="text" class="form-control" value="<?=$infos['address']?>">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" name="CHANGSHIPPING" class="btn btn-info" style="margin-top:35px;">Select Shipping Info</button>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                        <div id="add_address"></div>
                        <button class="btn btn-info" id="btn_add_address">Add Address</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-danger products"
                        data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
  <script>
        var adding_address = $('#add_address');
        $("#btn_add_address").click(function () {
            var rowhtml = `
                <form action="../Controller/shopController.php?" method="POST">
                    <div class="row">
                        <div class="col-3">
                            <label for="">FullName</label>
                            <input type="text" class="form-control" name="fullname">
                        </div>
                        <div class="col-3">
                            <label for="">Contact Number</label>
                            <input type="text" class="form-control" name="contact">
                        </div>
                        <div class="col-3">
                            <label for="">Address</label>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="col-3">
                            <div class="d-flex" style="margin-top:35px;">
                                <button type="submit" name="ADDSHIPPINGINFO" class="btn btn-info" style="margin-right:10px;">Submit</button>
                                <button class="btn btn-danger" id="remove">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>`;

            adding_address.append(rowhtml);
        });
        
        adding_address.on("click", "#remove", function () {
            const row = $(this).closest(".row");
            if (row.length > 0) {
                row.remove();
            }
        });
        




         $("#btn_changeSHIPPING").click(function () {
             $('#ShippingInfo').modal('show');
        });


        const fileInput = $("#image");
        const imagePreview = $("#image-preview");
        fileInput.change(function () {
            // Check if a file is selected
            if (fileInput[0].files.length > 0) {
                const file = fileInput[0].files[0];
                const reader = new FileReader();

                // Set up a FileReader to read the selected file
                reader.onload = function (e) {
                    // Set the source of the image preview to the selected file
                    imagePreview.attr("src", e.target.result);
                    imagePreview.show(); // Display the image preview
                };

                // Read the file as a data URL, triggering the onload event
                reader.readAsDataURL(file);
            } else {
                // If no file is selected, clear the image preview and hide it
                imagePreview.attr("src", "");
                imagePreview.hide();
            }
        });
    </script>
</body>

</html>
