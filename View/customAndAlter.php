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
                                        <a href="myShop.php" class="nav-link">My shop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="customAndAlter.php" class="nav-link active">Custom & Alter Transaction</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="mySubscription.php" class="nav-link">Manage Subscription</a>
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
                                                <td><button class="btn btn-info">View Feedback</button></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            More Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="#viewmore-Modal<?php echo $data['id'] ?>" data-toggle="modal" class="btn btn-info dropdown-item">View Details</a>
                                                            <a href="chat.php?user=<?=$data['user_id']?>" class="btn btn-info dropdown-item">Chat</a>
                                                            <?php if($data['status'] == 'Pending') {?>
                                                                <form action="../Controller/shopController.php" method="POST">
                                                                <input type="hidden" name="custom_alterid" value="<?php echo $data['id'] ?>">
                                                                <button type="submit" name="CANCEL" class="btn btn-danger dropdown-item">Cancel</button>
                                                                </form>
                                                            <?php } ?>
                                                            <?php if($data['price'] != ''){ ?>
                                                                    <a href="#payment-Modal<?php echo $data['id'] ?>" data-toggle="modal"  class="btn btn-info dropdown-item">Payment</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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
                                                                        <?php while($images = mysqli_fetch_assoc( $dataImage)){?>
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
                                                                <h3>Type Of Payment</h3>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <label for="">Cash On Delivery</label>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="hidden" name="shop_customoralter_id" value="<?php echo $data['id'] ?>">
                                                                        <input type="radio" class="payment_type" id="btn_cod" name="payment-type" value="Cash On Delivery" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <label for="">Online Payment</label>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="radio" class="payment_type btn_online" id="btn_op" name="payment-type" value="Online Payment" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" id="fee">
                                                                    <label for="">Fee</label>
                                                                    <input type="text" class="form-control" value="<?php echo $data['price'] ?>" readonly>
                                                                </div>
                                                                <div id="shop_gcash_info" style="display:none;">
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="email">Gcash Name</label>
                                                                                <input type="text" class="form-control" value="<?= $customer['gcash_name'] ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="email">Gcash Number</label>
                                                                                <input type="text" class="form-control" value="<?= $customer['gcash_number'] ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email">Total Fee</label>
                                                                        <input type="text" class="form-control" name="amount" value="<?= $data['price'] ?>" readonly>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="file" name="image" id="imageInput" accept="image/*" >
                                                                    </div>
                                                                    <div class="preview">
                                                                        <img id="imagePreview" src="#" alt="Image Preview" style="height: 140px; display: none;">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email">Reference number</label>
                                                                        <input type="text" class="form-control" name="reference_number"
                                                                            placeholder="Enter Reference number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                                    Close
                                                                </button>
                                                                <button type="submit" name="PAYMENT123" class="btn btn-info">
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
    <?php 
        include("../layouts/jsfile.layout.php");
        include("toastr.php");
    ?>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        $(document).on('click', '#btn_op', function () {
            $("#shop_gcash_info").show();
            $("#fee").hide();
        });

        $(document).on('click', '#btn_cod', function () {
            $("#fee").show();
            $("#shop_gcash_info").hide();
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
