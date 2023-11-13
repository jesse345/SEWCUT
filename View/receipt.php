<?php
include("../Model/db.php");
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
if($_GET['reference_order'] == ""){
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.layout.php")?>
    <title>My Product</title>
    <style>
        body{
            background-color:#eee;
            }
    </style>
</head>
<body>
    <?php
    $order1 = getrecord('orders','reference_order', $_GET['reference_order']);
    $user = mysqli_fetch_assoc(getrecord('user_details','id',$_SESSION['id']));
    $order = mysqli_fetch_assoc(getrecord('orders','reference_order',$_GET['reference_order']));
    $order_payment = mysqli_fetch_assoc(getrecord('order_payments','order_id',$order['id']));
    $buyer = mysqli_fetch_assoc(getrecord('user_details','id',$order['user_id']));
    $address = mysqli_fetch_assoc(getrecord('shipping_info','user_id',$order['user_id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container-fluid">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Official Receipt</li>
                    </ol>
                </div><!-- End .container-fluid -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="page-content">
                <div class="checkout">
                    <div class="container w-50 mt-5">
                        <div class="my-auto">
                            <div class=" summary" id="table-summary">
                                <button type="submit" class="btn btn-info btn-order float-right" onclick="downloadImage()">
                                    <span class="btn-text">Download Receipt</span>
                                    <span class="btn-hover-text">Download Receipt</span>
                                </button>
                                <h3 class="summary-title">
                                    <p>
                                        <?php echo date('M d Y H:i:s', strtotime($order_payment['created_at'])) ?>
                                    </p>
                                    <br>
                                    Sewcut Official Receipt
                                </h3><!-- End .summary-title -->
                                <h4 class="summary-title">Reference Order No: <?php echo $order['reference_order'] ?></h4>
                                <h4 class="summary-title"><a href="#modal-addpost" class="btn btn-info" data-toggle="modal">View proof of payment</a></h4>

                                <h4 class="summary-title">Transaction Details:</h4>
                                <p>
                                    Full Name: <?php echo ucfirst($buyer['firstname']) . " " .   ucfirst($buyer['lastname']); ?>
                                </p>
                                <p>Address: <?php echo ucfirst($address['address']) ?></p>
                                <p>Contact Number: <?php echo$address['contact'] ?></p>
                                <hr>
                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $subtotal = 0;
                                        while($o = mysqli_fetch_assoc($order1)):
                                            $product = mysqli_fetch_assoc(getrecord('product_details','id', $o['product_id']));
                                            $cart = mysqli_fetch_assoc(getrecord('carts','id', $o['cart_id']));
                                            $subtotal += $cart['total'];
                                            ?>
                                            <tr>
                                                <td><a href="#"><?php echo $product['product_name'] ?></a></td>

                                                <td><?php echo number_format($cart['quantity']) ?></td>
                                                <td>₱ <?php echo number_format($cart['total'], 2) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td></td>
                                                <td>₱ <?php echo number_format($subtotal, 2) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>

                        


                    </div>
                </div>
            </div>
        </main><!-- End .main -->
        <div class="modal fade" id="modal-addpost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">PROOF OF PAYMENT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="icon-close"></i></span>
                        </button>
                    </div>

                    <div class="modal-body p-5">
                        <div class="d-block">

                            <div class="form-group">
                                <label class="form-label">PAYMENT RECEIPT</label>
                                <img src="<?php echo $order_payment['receipt_image'] ?>" class="img-thumbnail" style="width:70%;height:250px;">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php include("../layouts/jsfile.layout.php"); ?>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
    function downloadImage() {
        html2canvas(document.querySelector(".my-auto")).then(function(canvas) {
            var link = document.createElement("a");
            document.body.appendChild(link);
            link.download = "receipt.png";
            link.href = canvas.toDataURL();
            link.target = '_blank';
            link.click();
        });
    }
</script>
</body>
</html>