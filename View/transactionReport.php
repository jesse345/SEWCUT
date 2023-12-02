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

</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $admin = mysqli_fetch_assoc(getallrecord('admin'));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <div class="container mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transaction Report</li>
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
                                        <a href="customAndAlter.php" class="nav-link">Custom & Alter Transaction</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="mySubscription.php" class="nav-link">Manage Subscription</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="transactionReport.php" class="nav-link active">Transaction Report</a>
                                    </li>
                                </ul>
                            </aside>
                            <div class="col-10">   
                                <button class="btn btn-success float-right mb-2" onclick="downloadImage()">Download</button>
                                <table class="table table-hover text-center mt-2" id="tableContent">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>ORDER BY</th>
                                            <th>TYPE</th>
                                            <th>PRODUCT NAME</th>
                                            <th>TOTAL PRICE</th>
                                            <TH>STATUS</TH>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $order_count = 0;
                                        $totalIncome = 0;
                                        $order = getrecord('orders', 'seller_id', $_SESSION['id']);
                                        while ($ord = mysqli_fetch_assoc($order)) {
                                            if($ord['status'] == 'Received'){
                                                $totalIncome += $ord['total'];
                                                $order_count++;
                                                $order_by = mysqli_fetch_assoc(getrecord('user_details','id',$ord['user_id']));
                                                $product = mysqli_fetch_assoc(getrecord('product_details','id',$ord['product_id']));?>
                                                <tr>
                                                    <td><?=$order_count?></td>
                                                    <td><?=ucfirst($order_by['firstname']) . ' ' .ucfirst($order_by['lastname']) ?></td>
                                                    <td>ORDERS</td>
                                                    <td><?=$product['product_name'] ?></td>
                                                     <td><button class="btn btn-info">Successful</button></td>
                                                    <td><?=number_format($ord['total'],2) ?></td>
                                                   
                                                </tr>
                                          <?php } ?>
                                        <?php } ?>
                                        <?php 
                                        $custom_alter = getallrecord('shop_customoralter');
                                        while($cOr = mysqli_fetch_assoc($custom_alter)){
                                            $order_count++;
                                            $order_by1 = mysqli_fetch_assoc(getrecord('user_details','id',$cOr['user_id']));
                                            $shop = mysqli_fetch_assoc(getrecord('shops','id',$cOr['shop_id']));
                                            if($shop['user_id'] == $_SESSION['id']){
                                                if($cOr['status'] == 'Received'){
                                                    $totalIncome += $cOr['price'];
                                                    ?>
                                                    <tr>
                                                        <td><?=$order_count?></td>
                                                        <td><?=ucfirst($order_by1['firstname']) . ' ' .ucfirst($order_by1['lastname']) ?></td>
                                                        <td><?=strtoupper($cOr['type'])?></td>
                                                        <td></td>
                                                        <td><button class="btn btn-info">Successful</button></td>
                                                        <td><?=$cOr['price']?></td>
                                                        
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td>Total Income: <b><?=number_format($totalIncome,2)?></b></td>
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
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        function downloadImage() {
            html2canvas(document.querySelector('#tableContent')).then(function(canvas) {
                var link = document.createElement('a');
                document.body.appendChild(link);
                link.download = 'receipt.png';
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }

    </script>

</body>
</html>
