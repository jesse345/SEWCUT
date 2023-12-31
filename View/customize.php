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
        .imagePreviews img {
            max-width: 100px;
            max-height: 100px;
            margin: 5px;
        }
        .form-control{
            border:1px solid #000;
        }
        .image-upload > input
        {
            display: none;
        }
        .upload-icon{
        width: 100px;
        height: 97px;
        border: 2px solid #5642BE;
        border-style: dotted;
        border-radius: 18px;
        }
        .upload-icon img{
        width: 60px;
        height: 60px;
        margin:19px;
        cursor: pointer;
        }
        .upload-icon.has-img {
            width: 100px;
            height: 97px;
            border: none;
        }
        .upload-icon.has-img img {
            width: 100%;
            height: auto;
            border-radius: 18px;
            margin:0px;
        }
        .image-upload {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .upload-icon {
            cursor: pointer;
        }

        .has-img {
            /* Add styling for elements with an image here */
        }
    </style>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $address = mysqli_fetch_assoc(getrecord('address', 'id', $user['address']));
    $user1 = mysqli_fetch_assoc(getrecord('users', 'id', $_SESSION['id']));
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
                <form action="../Controller/shopController.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="shop_id" value="<?=$_GET['shop_id']?>">
                    <div id="page1" class="form-page">
                        <div class="row">
                            <div class="col-12">
                                <label>Name</label>
                                <div class="form-group">
                                    <input type="text" name="customer_name" class="form-control" value="<?=ucfirst($user['firstname']) . ' ' . ucfirst($user['lastname'])?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="phoneNumber">Phone Number</label>
                                <div class="form-group">
                                    <input type="text" name="phoneNumber" class="form-control" value="<?=$user['contact_number']?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="email">Email Address</label>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control"  value="<?=$user1['email']?>">
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
                        <label class="mt-2">Please Upload Image(s) of your chosen Design</label><br>
                        <input type="file" name="image[]" id="fileInput" multiple>
                        <div class="imagePreviews" style="display: flex;"></div>
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
                                        <!-- <div class="dropdown show mt-1" id="fabric_types">
                                            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Fabric Types
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="btn dropdown-item" href="#">Action</a>
                                                <a class="btn dropdown-item" href="#">Another action</a>
                                                <a class="btn dropdown-item" href="#">Something else here</a>
                                            </div>
                                            </div> -->
                                        </center>
                                    </div>
                                    <div class="col-8">
                                        <label for="">INPUT YOUR DESIRED MEASUREMENTS</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">NECK(CM)</label>
                                                    <input type="text" class="form-control men" value="0" name="men_neck">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">SHOULDER(CM)</label>
                                                    <input type="text" class="form-control men" value="0" name="men_shoulder">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">SLEEVE(CM)</label>
                                                    <input type="text" class="form-control men" value="0" name="men_sleeve">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">CHEST(CM)</label>
                                                    <input type="text" class="form-control men" value="0" name="men_chest">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">WAIST(CM)</label>
                                                    <input type="text" class="form-control men" value="0" name="men_waist">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">HIPS(CM)</label>
                                                    <input type="text" class="form-control men" value="0" name="men_hips">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">INSEAM(CM)</label>
                                                    <input type="text" class="form-control men" value="0" name="men_inseam">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">THIGH(CM)</label>
                                                    <input type="text" class="form-control men" value="0" name="men_thigh">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <b>OPTIONAL MEASUREMENT</b>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">HEIGHT FEET AND INCHES</label>
                                                    <input type="text" class="form-control men" value="0" name="men_height">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">BODICE LENGTH</label>
                                                    <input type="text" class="form-control men" value="0" name="men_bodice">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                    <input type="text" class="form-control women" value="0" name="neck">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">SHOULDER(CM)</label>
                                                    <input type="text" class="form-control women" value="0" name="shoulder">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">SLEEVE(CM)</label>
                                                    <input type="text" class="form-control women" value="0" name="sleeve">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">CHEST(CM)</label>
                                                    <input type="text" class="form-control women" value="0" name="chest">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">WAIST(CM)</label>
                                                    <input type="text" class="form-control women" value="0" name="waist">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">HIPS(CM)</label>
                                                    <input type="text" class="form-control women" value="0" name="hips">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">INSEAM(CM)</label>
                                                    <input type="text" class="form-control women" value="0" name="inseam">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">THIGH(CM)</label>
                                                    <input type="text" class="form-control women" value="0" name="thigh">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <b>OPTIONAL MEASUREMENT</b>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">HEIGHT FEET AND INCHES</label>
                                                    <input type="text" class="form-control women" value="0" name="height">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">BODICE LENGTH</label>
                                                    <input type="text" class="form-control women" value="0" name="bodice">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label style="margin-bottom:0;">UNDER BUST(CM)</label>
                                                    <input type="text" class="form-control women" value="0" name="under_bust">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="tab-pane fade" id="tab-11" role="tabpanel" aria-labelledby="tab-11-tab">
                                <div class="form-group">
                                    <label for="">Address:</label>
                                    <input type="text" name="address" class="form-control address" id="myAddress">
                                </div>
                                <div class="form-group">
                                    <label for="">Schedule</label>
                                    <input type="date" name="schedule" class="form-control address">
                                </div>
                            </div>
                        </div><!-- End .tab-content -->
                        <div class="float-right">
                            <div style="margin-left:21px;margin-top:15px;">
                                <input type="checkbox" class="form-check-input" id="cbx_fabric" style="margin-top: 7px" name="fabrictype" value="OwnByCustomer">
                                <span style="margin-left: 7px "><b>I have a fabric</b></span>
                            </div>
                            <div class="dropdown show mt-1" id="fabric_types">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Fabric Types
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="fabricdropdown">
                                    <div class="form-check mb-1">
                                        <label class="form-check-label mx-5 " style="width:100%;">
                                            <input type="radio" class="form-check-input" id="fabrics" name="fabrictype" value="Cotton" style="margin-top:6px;"><span style="margin-left:10px;">Cotton</span>
                                        </label>
                                        <label class="form-check-label mx-5" style="width:100%;">
                                            <input type="radio" class="form-check-input" id="fabrics" name="fabrictype" value="Chiffon" style="margin-top:6px;"><span style="margin-left:10px;">Chiffon</span>
                                        </label>
                                        <label class="form-check-label mx-5" style="width:100%;">
                                            <input type="radio" class="form-check-input" id="fabrics" name="fabrictype" value="Denim" style="margin-top:6px;"><span style="margin-left:10px;">Denim</span>
                                        </label>
                                        <label class="form-check-label mx-5" style="width:100%;">
                                            <input type="radio" class="form-check-input" id="fabrics" name="fabrictype" value="Lace" style="margin-top:6px;"><span style="margin-left:10px;">Lace</span>
                                        </label>
                                        <label class="form-check-label mx-5" style="width:100%;">
                                            <input type="radio" class="form-check-input" id="fabrics" name="fabrictype" value="Linen" style="margin-top:6px;"><span style="margin-left:10px;">Linen</span>
                                        </label>
                                        <label class="form-check-label mx-5" style="width:100%;">
                                            <input type="radio" class="form-check-input" id="fabrics" name="fabrictype" value="Silk" style="margin-top:6px;"><span style="margin-left:10px;">Silk</span>
                                        </label>
                                        <label class="form-check-label mx-5" style="width:100%;">
                                            <input type="radio" class="form-check-input" id="fabrics" name="fabrictype" value="Wool" style="margin-top:6px;"><span style="margin-left:10px;">Wool</span>
                                        </label>
                                        <label class="form-check-label mx-5">
                                            <input type="radio"  name="fabrictype" class="form-check-input"  id="fabrictype_others" value="0" style="margin-top:6px;"><span style="margin-left:10px;">Others</span>
                                        </label>
                                        <input type="text" id="other_fabric" name="fabrictypeothers" class="form-control" style="display:none;width:90%;margin-left:5%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br><br><br>
                        <button type="button" class="btn btn-secondary btn_PreviousPage2">Previous</button>
                        <div class="float-right">
                            <!-- <button type="button" class="btn btn-success btn_Print" onclick="downloadImage()">Download</button> -->
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
    var address = '<?php echo $address['address']; ?>';
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
            $('#tab-10-tab').on('click', function (e) {
                $('.men').val(0);
                $('.address').val('');
    
            });
            $('#tab-9-tab').on('click', function (e) {
                $('.women').val(0);
                $('.address').val('');
                
            });
            $('#tab-11-tab').on('click', function (e) {
                $('.women').val(0);
                $('.men').val(0);
                $('#myAddress').val(address);
            });






            $('#fileInput').on('change', function (e) {
                var files = e.target.files;

                $('.imagePreviews').empty(); // Clear previous previews

                for (var i = 0; i < files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.imagePreviews').append('<img src="' + e.target.result + '" alt="Image Preview">');
                    };
                    reader.readAsDataURL(files[i]);
                }
            });
            
            $('#cbx_fabric').on('change', function() {
                $('#fabric_types').toggle();
            });


            $("#fabricdropdown").on('click', '#fabrictype_others', function () {
                $("#other_fabric").show();
            });
            $("#fabricdropdown").on('click', '#fabrics', function () {
                $("#other_fabric").hide();
            });
        });



        
       
         
    </script>


</body>

</html>
