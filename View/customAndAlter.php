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
    $shipping_info = mysqli_fetch_assoc(getRecentShippingAddress('shipping_info', 'user_id', $_SESSION['id']));
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
                                        <a href="myShop.php" class="nav-link">My shop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="customAndAlter.php" class="nav-link active">Custom & Alter Transaction</a>
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
                                <table class="table table-hover text-center mt-5">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:2%">#</th>
                                            <th style="width:15%">Shop Name</th>
                                            <th>TYPE</th>
                                            <th>STATUS</th>
                                            <th>PAYMENT TYPE</th>
                                            <th>FEEDBACK</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $count = 0 ;
                                    $customize = getrecord('shop_customoralter','user_id',$_SESSION['id']);
                                    while($data = mysqli_fetch_assoc($customize)){
                                        $count++;
                                        $shopOwner = mysqli_fetch_assoc(getrecord('shops','id',$data['shop_id']));
                                        $customer = mysqli_fetch_assoc(getrecord('user_details','id', $shopOwner['user_id']));
                                        $shopInfo = mysqli_fetch_assoc(getrecord('shop_info','shop_customoralter_id',$data['id']));
                                        $shopHomeService = getrecord('shop_homeservice','shop_customoralter_id',$data['id']);
                                        $shopMeasurement = mysqli_fetch_assoc(getrecord('shop_measurerments','shop_customoralter_id',$data['id']));
                                        $dataImage = getrecord('shop_images','shop_customoralter_id',$data['id']);
                                        $shopFeedback = getrecord('shop_feedbacks','shop_customoralter_id',$data['id']);
                                        $shop_customoralter_payments = getrecord('shop_customoralter_payments','shop_customoralter_id',$data['id']);
                                            ?>
                                            <tr>
                                                <td><?=$count?></td>
                                                <td><?=$shopOwner['shop_name']?></td>
                                                <td><button class="btn btn-warning"><?=$data['type']?></button></td>
                                                <td><button class="btn btn-warning"><?=$data['status']?></button></td>
                                                <td>
                                                    <?php if($data['payment_type'] != '') {?>
                                                        <button class="btn btn-warning"><?=$data['payment_type']?></button>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if($data['status'] == "Approved" || $data['status'] == "Shipped") {?>
                                                        <a href="#viewFeedback-Modal<?php echo $data['id'] ?>" data-toggle="modal" class="btn btn-info">View Feedback</a></td>
                                                    <?php } ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            More Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="#viewmore-Modal<?php echo $data['id'] ?>" data-toggle="modal" class="btn btn-info dropdown-item">View Details</a>
                                                            <a href="chat.php?user=<?=$data['user_id']?>" class="btn btn-info dropdown-item">Chat</a>
                                                            <?php if($data['status'] == 'Pending' && $data['payment_type'] == '') {?>
                                                                <form action="../Controller/shopController.php" method="POST">
                                                                    <input type="hidden" name="custom_alterid" value="<?php echo $data['id'] ?>">
                                                                    <button type="submit" name="CANCEL" class="btn btn-danger dropdown-item">Cancel</button>
                                                                </form>
                                                            <?php }elseif($data['status'] == 'Shipped') {?>
                                                                    <form action="../Controller/shopController.php" method="POST">
                                                                        <input type="hidden" name="custom_alterid" value="<?php echo $data['id'] ?>">
                                                                        <button type="submit" name="RECEIVE" class="btn btn-danger dropdown-item">Receive</button>
                                                                    </form>
                                                            <?php } ?>
                                                            <?php if(mysqli_num_rows($shop_customoralter_payments) > 0 ) {?>
                                                                <a href="#viewProofOfPayment-Modal<?php echo $data['id'] ?>" data-toggle="modal" class="dropdown-item" style="font-size:15px">View Proof of Payment</abs>
                                                            <?php } ?>  
                                                            <?php if($data['price'] != '' && $data['payment_type'] == ''){ ?>
                                                                    <a href="#payment-Modal<?php echo $data['id'] ?>" data-toggle="modal"  class="btn btn-info dropdown-item">Payment</a>
                                                            <?php } ?>
                                                            <?php if($data['status'] == 'DisApproved' || $data['status'] == 'Received') {?>
                                                                <a href="#report-Modal<?php echo $data['id'] ?>"
                                                                    data-toggle="modal" class="btn btn-info dropdown-item">Report</a>
                                                            <?php } ?>  
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="report-Modal<?php echo $data['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content p-5">
                                                        <form action="../Controller/orderController.php" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="seller_id" value="<?=$shopOwner['user_id']?>">
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
                                            <div class="modal fade" id="viewProofOfPayment-Modal<?php echo $data['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <?php while($image = mysqli_fetch_assoc($shop_customoralter_payments)) { ?>
                                                                        <center>
                                                                            <img src="<?php echo $image['receipt_image'] ?>" class="img-thumbnail" style="width:80%;height:250px;">
                                                                        </center>
                                                                    <?php } ?>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="viewFeedback-Modal<?php echo $data['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3>View Feedback</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <?php while($sf = mysqli_fetch_assoc($shopFeedback)){ 
                                                                    
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-7">
                                                                            <textarea name="feedback" class="form-control" cols="30" rows="5" readonly><?=$sf['feedbacks']?></textarea>
                                                                        </div>
                                                                        <div class="col-5 my-auto">
                                                                            <input type="text" value="<?= date('M d Y H:i:s', strtotime($sf['created_at'])) ?>" class="form-control" readonly>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                <?php } ?>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                                Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="viewmore-Modal<?php echo $data['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog custom-modal" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <p>View Details</p>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true"><i class="icon-close"></i></span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" id="downlad_preview">
                                                            <label>INFO</label> 
                                                            <div class="form-group mt-2">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control" value="<?=$shopInfo['name'] ?>"  readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Phone Number</label>
                                                                <input type="text" class="form-control" value="<?=$shopInfo['phone'] ?>"  readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="text" class="form-control" value="<?=$shopInfo['email'] ?>"  readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Category</label>
                                                                <input type="text" class="form-control" value="<?=$shopInfo['category'] ?>"  readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Instruction</label>
                                                                <input type="text" class="form-control" value="<?=$shopInfo['instruction'] ?>"  readonly>
                                                            </div>
                                                                <div class="form-group mb-2">
                                                                <label>Image Design</label>
                                                                <div class="preview-item">
                                                                    <div class="row">
                                                                        <?php while($images = mysqli_fetch_assoc($dataImage)){?>
                                                                            <div class="col-3">
                                                                                <img src="<?php echo $images['images']; ?>">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <?php if(mysqli_num_rows($shopHomeService) > 0 ){
                                                                $homeservice = mysqli_fetch_assoc($shopHomeService);
                                                                ?>
                                                                
                                                                <label>Home Service Info</label> 
                                                                <div class="row mt-2">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label>Address</label>
                                                                            <input type="text" class="form-control" value="<?=$homeservice['address'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label>Schedule</label>
                                                                            <input type="text" class="form-control" value="<?=$homeservice['schedule'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            <?php }else{?>
                                                                <label>MEASUREMENTS</label> 
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Neck</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['neck'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Shoulder</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['shoulder'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Sleeve</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['sleeve'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Chest</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['chest'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Waist</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['waist'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Hips</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['hips'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Inseam</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['inseam'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Thigh</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['thigh'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Height</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['height'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Bodice</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['bodice'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Bust</label>
                                                                            <input type="text" class="form-control" value="<?=$shopMeasurement['bust'] ?>"  readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php if($data['type'] == 'Alter') {?>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Garment Type</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['garment_type'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Alter Type</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['alter_type'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                             <button type="button" class="btn btn-success btn_Print" onclick="downloadImage()">Download</button>
                                                            <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                                Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="payment-Modal<?php echo $data['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="../Controller/shopController.php" method="POST">
                                                            <div class="modal-body">
                                                                <h3 class="summary-title">Shipping Info</h3>
                                                                <div class="form-group">
                                                                    <label>FullName</label>
                                                                    <input type="text" class="form-control" name="fullname"
                                                                        value="<?= ucfirst($shipping_info['name']) ?>" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Contact Number</label>
                                                                    <input type="text" class="form-control" name="contact_number"
                                                                        value="<?= $shipping_info['contact'] ?>" readonly> 
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <input type="text" class="form-control" name="address"
                                                                        value="<?= $shipping_info['address'] ?>" readonly>
                                                                </div>
                                                                <a href="#ShippingInfo" data-toggle="modal" type="button" class="btn btn-info float-right mb-2">
                                                                    Change Shipping Info
                                                                </a>
                                                                <h3 class="summary-title mt-10">Type Of Payment</h3>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <label for="">Cash On Delivery</label>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="hidden" name="shop_customoralter_id" value="<?php echo $data['id'] ?>">
                                                                        <input type="radio" class="payment_type" name="payment-type" value="Cash On Delivery" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <label for="">Online Payment</label>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="radio" class="payment_type" name="payment-type" value="Online Payment" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" id="fee">
                                                                    <label for="">Fee</label>
                                                                    <input type="text" class="form-control" value="<?= $data['price']?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                                    Close
                                                                </button>
                                                                <button type="submit" name="CHOOSEPAYMENT" class="btn btn-info">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
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

    <?php $shipping_info1 = getrecord('shipping_info','user_id',$_SESSION['id'])?>
    <div class="modal fade" id="ShippingInfo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog custom-modal"
            role="document" style="max-width:1000px;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card-body" id="shippingInfos">
                        <?php 
                        $count = 0;
                        while($infos = mysqli_fetch_assoc($shipping_info1)) {
                            ?>
                            <form action="../Controller/shopController.php" method="POST">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="">FullName</label>
                                        <input type="hidden" name="shipping_info_id" value="<?=$infos['id']?>">
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
                                    <div class="col-3" style="margin-top:35px;">
                                        <?php if($shipping_info['id'] == $infos['id']) {?>
                                             <div class="row">
                                                <div class="col-6">
                                                    <button type="button"  class="btn btn-success" >Selected</button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger" id="btn_deletePayment" data-id="<?=$infos['id']?>">Delete</button>
                                                </div>
                                            </div>
                                        <?php } else {?>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="submit" name="CHANGSHIPPING" class="btn btn-info" >Select</button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger" id="btn_deletePayment" data-id="<?=$infos['id']?>">Delete</button>
                                                </div>
                                            </div>
                                        <?php } ?>
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
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
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
                                <button type="submit" name="ADDSHIPPINGINFO" class="btn btn-info" s>Submit</button>
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

        $("#shippingInfos").on('click', '#btn_deletePayment', function () {
            var dataId = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "../Controller/shopController.php",
                data: {
                    DELETESHIPPINGINFO: true, 
                    ID : dataId
                },
                success: function (response) {
                    console.log(response);
                    location.reload();

                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });
        });

        function downloadImage() {
            html2canvas(document.querySelector('#downlad_preview')).then(function(canvas) {
                var link = document.createElement('a');
                document.body.appendChild(link);
                link.download = 'receipt.png';
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }

        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function (e) {
            if (e.target.files.length === 0) {
                return;
            }
            let file = e.target.files[0];
            let url = URL.createObjectURL(file);
            imagePreview.src = url;

            // Display the preview image
            imagePreview.style.display = 'block';
        });
    </script>
</body>
</html>
