<?php
include("../Model/db.php");
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../layouts/head.layout.php") ?>
    
    <style>
        .form-control{
            border:1px solid #000;
        }
    </style>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $shop = mysqli_fetch_assoc(getrecord('shops', 'id', $_GET['shop_id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                        <li class="breadcrumb-item"><a href="storeShop.php?shop_id=<?=$_GET['shop_id']?>"> <?= $shop['shop_name'] ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Customize Product
                        </li>
                    </ol>
                </div><!-- End .container-fluid -->
            </nav><!-- End .breadcrumb-nav -->
        </main><!-- End .main -->
        <div class="container">
            <div class="mx-auto" style="border: 1px solid #000; padding: 40px; width: 80%;">
                <form action="../Controller/shopController.php" method="POST">
                    <input type="hidden" name="shop_id" value="<?=$_GET['shop_id']?>">
                    <div id="page1" class="form-page">
                        <div class="row">
                            <div class="col-12">
                                <label>Name</label>
                                <div class="form-group">
                                    <input type="text" name="customer_name" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="phoneNumber">Phone Number</label>
                                <div class="form-group">
                                    <input type="text" name="phoneNumber" class="form-control" >
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="email">Email Address</label>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <label for="category">Categories Available</label><br>
                        <?php
                        $data = getrecord('shop_details', 'shop_id', $_GET['shop_id']);
                        while ($shop_details = mysqli_fetch_assoc($data)) { ?>
                            <div class="form-group d-inline" style="margin-right: 15px;">
                                <input type="radio" name="category" value="<?= $shop_details['category'] ?>"> <?= $shop_details['category'] ?>
                            </div>
                        <?php } ?>
                        <br>
                        <label class="mt-2">Please Upload Image(s) of your chosen Design</label>
                        <div class="form-group">
                            <input type="file">
                        </div>
                        <div class="form-group">
                            <label>Special Instruction to the Tailor/Dressmaker, Like the fabric you want etc.</label>
                            <textarea class="form-control" rows="5" name="instruction"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary float-right mb-5 btn_page1">Next</button><br>
                    </div>
                    <div id="page2" class="form-page d-none">
                        <ul class="nav nav-tabs nav-tabs-bg justify-content-center" id="tabs-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-9-tab" data-toggle="tab" href="#tab-9" role="tab" aria-controls="tab-9" aria-selected="true">Men</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-10-tab" data-toggle="tab" href="#tab-10" role="tab" aria-controls="tab-10" aria-selected="false">Women</a>
                            </li>
                            <?php if($shop['CanHomeService'] == 'Yes'){?>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-11-tab" data-toggle="tab" href="#tab-11" role="tab" aria-controls="tab-11" aria-selected="false">Request Home Service</a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content tab-content-border" id="tab-content-3">
                            <div class="tab-pane fade show active" id="tab-9" role="tabpanel" aria-labelledby="tab-9-tab">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="../images/measurements.png" alt="">
                                        <center class="mt-3">
                                        <a href="guide.php"><b><u>MEASUREMENT GUIDES</u></b></a>
                                        </center>
                                    </div>
                                    <div class="col-8">
                                        <label for="">INPUT YOUR DESIRED MEASURERMENTS</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">NECK(CM)</label>
                                                    <input type="text" class="form-control" name="neck">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">SHOULDER(CM)</label>
                                                    <input type="text" class="form-control" name="shoulder">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">SLEEVE(CM)</label>
                                                    <input type="text" class="form-control" name="sleeve">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">CHEST(CM)</label>
                                                    <input type="text" class="form-control" name="chest">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">WAIST(CM)</label>
                                                    <input type="text" class="form-control" name="waist">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">HIPS(CM)</label>
                                                    <input type="text" class="form-control" name="hips">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">INSEAM(CM)</label>
                                                    <input type="text" class="form-control" name="inseam">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">THIGH(CM)</label>
                                                    <input type="text" class="form-control" name="thigh">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <b>OPTIONAL MEASUREMENT</b>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">HEIGHT FEET AND INCHES</label>
                                                    <input type="text" class="form-control" name="height">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">BODICE LENGTH</label>
                                                    <input type="text" class="form-control" name="bodice">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="tab-10" role="tabpanel" aria-labelledby="tab-10-tab">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="../images/measurements.png" alt="">
                                        <center class="mt-3">
                                        <a href="guide.php"><b><u>MEASUREMENT GUIDES</u></b></a>
                                        </center>
                                    </div>
                                    <div class="col-8">
                                        <label for="">INPUT YOUR DESIRED MEASURERMENTS</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">NECK(CM)</label>
                                                    <input type="text" class="form-control" name="neck">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">SHOULDER(CM)</label>
                                                    <input type="text" class="form-control" name="shoulder">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">SLEEVE(CM)</label>
                                                    <input type="text" class="form-control" name="sleeve">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">CHEST(CM)</label>
                                                    <input type="text" class="form-control" name="chest">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">WAIST(CM)</label>
                                                    <input type="text" class="form-control" name="waist">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">HIPS(CM)</label>
                                                    <input type="text" class="form-control" name="hips">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">INSEAM(CM)</label>
                                                    <input type="text" class="form-control" name="inseam">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">THIGH(CM)</label>
                                                    <input type="text" class="form-control" name="thigh">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <b>OPTIONAL MEASUREMENT</b>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">HEIGHT FEET AND INCHES</label>
                                                    <input type="text" class="form-control" name="height">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">BODICE LENGTH</label>
                                                    <input type="text" class="form-control" name="bodice">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">UNDER BUST(CM)</label>
                                                    <input type="text" class="form-control" name="under_bust">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- .End .tab-pane -->
                             <div class="tab-pane fade" id="tab-11" role="tabpanel" aria-labelledby="tab-11-tab">
                                <div class="form-group">
                                    <label for="">Address:</label>
                                    <input type="text" name="address" class="form-control" placeholder="Enter your Address">
                                </div>
                                <div class="form-group">
                                    <label for="">Schedule</label>
                                    <input type="date" name="schedule" class="form-control">
                                </div>
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                        <br>
                        <button type="button" class="btn btn-secondary btn_PreviousPage2">Previous</button>
                        <div class="float-right">
                            <button type="button" class="btn btn-success btn_Print" onclick="downloadImage()">Download</button>
                            <button type="button" class="btn btn-secondary btn_Clearform">Clear Form</button>
                            <button type="submit" class="btn btn-info btn_page2" name="CUSTOMIZESUBMIT">Submit</button>
                        </div>
                        <br>
                    </div>
                </form>
            </div>
        </div>

        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
    function downloadImage() {
        html2canvas(document.querySelector('.mx-auto')).then(function(canvas) {
            var link = document.createElement('a');
            document.body.appendChild(link);
            link.download = 'receipt.png';
            link.href = canvas.toDataURL();
            link.target = '_blank';
            link.click();
        });
    }
    $(document).ready(function() {
        $('.btn_page1').on('click', function (e) {
            $('#page2').removeClass('d-none');
            $('#page1').addClass('d-none');
        });
        // SECOND PAGE
        $('.btn_PreviousPage2').on('click', function (e) {
            $('#page2').addClass('d-none');
            $('#page1').removeClass('d-none');
        });
        // CLEAR FORM
        $('.btn_Clearform').on('click', function (e) {
             $('.form-control').val('');
        });
        
     });
</script>


</body>

</html>
