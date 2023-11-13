<?php
include("../Model/db.php");
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$admin = mysqli_fetch_assoc(getallrecord('admin'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/subscription.css">
    <?php include("../layouts/head.layout.php") ?>
    <title>My Product</title>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscription</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->
        <div class="container mb-15">
            <div class="row">
                <?php
                $user = subscriptionForFree($_SESSION['id']);
                if (mysqli_num_rows($user) < 1) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="pricingTable green">
                        <div class="pricingTable-header">
                            <h3>Free Trial</h3>
                        </div>
                        <div class="pricing-plans">
                            <span class="price-value"><i class="fa fa-usd"></i><span>Free</span></span>

                        </div>
                        <div class="pricingContent">
                            <ul>
                                <li><b>1 month Duration</b> </li>
                            </ul>
                        </div>
                        <!-- CONTENT BOX-->
                        <div class="pricingTable-sign-up">
                            <button type="button" href="#FreeSubscribe" data-toggle="modal"
                                class="btn btn-success">Use</button>
                        </div>
                        <!-- BUTTON BOX-->
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="pricingTable purple">
                        <div class="pricingTable-header">
                            <h3>Standard</h3>

                        </div>
                        <div class="pricing-plans">
                            <span class="price-value"><i class="fa fa-usd"></i><span>₱199.00</span></span>

                        </div>
                        <div class="pricingContent">
                            <ul>
                                <li><b>3 months Duration </b> </li>
                            </ul>
                        </div>
                        
                        <div class="pricingTable-sign-up">
                            <button type="button" id="btn_Subscribe" data-value="199" data-type="1"
                                class="btn btn-success">Subscribe</button>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="pricingTable yellow">
                        <div class="pricingTable-header">
                            <h3>Advance</h3>

                        </div>
                        <div class="pricing-plans">
                            <span class="price-value"><i class="fa fa-usd"></i><span>₱399.00</span></span>
                        </div>
                        <div class="pricingContent">
                            <ul>
                                <li><b>6 months Duration </b> </li>
                            </ul>
                        </div>
                        
                        <div class="pricingTable-sign-up">
                            <button type="button" id="btn_Subscribe2" data-value="399" data-type="2"
                                class="btn btn-success">Subscribe</button>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-3 col-sm-6"> 
                    <div class="pricingTable purple">
                        <div class="pricingTable-header">
                            <h3>Premium</h3>
                        </div>
                        <div class="pricing-plans">
                            <span class="price-value"><i class="fa fa-usd"></i><span>₱699.00</span></span>

                        </div>
                        <div class="pricingContent">
                            <ul>
                                <li><b>1 year Duration </b> </li>
                            </ul>
                        </div>
                        <!-- CONTENT BOX-->
                        <div class="pricingTable-sign-up">
                            <button type="button" id="btn_Subscribe3" data-value="699" data-type="3"
                                class="btn btn-success">Subscribe</a>
                        </div>
                        <!-- BUTTON BOX-->
                    </div>
                </div>
                <?php } else{?>
                <div class="col-md-4 col-sm-6">
                    <div class="pricingTable purple">
                        <div class="pricingTable-header">
                            <h3>Standard</h3>

                        </div>
                        <div class="pricing-plans">
                            <span class="price-value"><i class="fa fa-usd"></i><span>₱199.00</span></span>

                        </div>
                        <div class="pricingContent">
                            <ul>
                                <li><b>3 months Duration </b> </li>
                            </ul>
                        </div>
                        
                        <div class="pricingTable-sign-up">
                            <button type="button" id="btn_Subscribe" data-value="199" data-type="1"
                                class="btn btn-success">Subscribe</button>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="pricingTable yellow">
                        <div class="pricingTable-header">
                            <h3>Advance</h3>

                        </div>
                        <div class="pricing-plans">
                            <span class="price-value"><i class="fa fa-usd"></i><span>₱399.00</span></span>
                        </div>
                        <div class="pricingContent">
                            <ul>
                                <li><b>6 months Duration </b> </li>
                            </ul>
                        </div>
                        
                        <div class="pricingTable-sign-up">
                            <button type="button" id="btn_Subscribe2" data-value="399" data-type="2"
                                class="btn btn-success">Subscribe</button>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-4 col-sm-6"> 
                    <div class="pricingTable purple">
                        <div class="pricingTable-header">
                            <h3>Premium</h3>
                        </div>
                        <div class="pricing-plans">
                            <span class="price-value"><i class="fa fa-usd"></i><span>₱699.00</span></span>

                        </div>
                        <div class="pricingContent">
                            <ul>
                                <li><b>1 year Duration </b> </li>
                            </ul>
                        </div>
                        <!-- CONTENT BOX-->
                        <div class="pricingTable-sign-up">
                            <button type="button" id="btn_Subscribe3" data-value="699" data-type="3"
                                class="btn btn-success">Subscribe</a>
                        </div>
                        <!-- BUTTON BOX-->
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    include('../assets/js/prod.php');
    ?>
    <!-- Modal -->
    <div class="modal fade" id="modal-payment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gcash Payment</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="../Controller/subscriptionController.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div>
                            <img src="https://mcdn.pybydl.com/lco/assets/payment/logo/gcash-353da48c3e4788d6e671a2aa05f783ea08cb6f8547713212ca7d6daf636e959c.svg"
                                class="mx-auto d-block" style="width:50%;height:150px;" alt="">
                        </div>
                        <div style="margin-left:40px;margin-right:40px;">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Gcash Name</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    value="<?= $admin['gcash_name'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gcash Number</label>
                                <input type="text" class="form-control" value="<?= $admin['gcash_number'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <input type="text" class="form-control" name="amount" id="amount" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Upload Receipt</label><br>
                                <input type="file" name="image" id="image" required>
                            </div>
                            <img id="image-preview" src="" alt="Image Preview"
                                style="max-width: 100%; max-height: 200px;display:none;">

                            <div class="form-group">
                                <label class="form-label">Reference No</label>
                                <input type="text" class="form-control" name="ref" id="reference-no"
                                    placeholder="Enter Reference No" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="subscribe" id="subscribe">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="FreeSubscribe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="../Controller/subscriptionController.php" method="POST">
                    <div class="modal-body">
                        <center>
                            <p style="font-size: 15px; font-weight: 500;margin-top:50px;">Are you sure you want to use your free trial ?</p>
                        </center>
                    </div>
                    <div class="modal-footer footer1 mt-5">
                        <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                            No
                        </button>
                        <button type="submit" class="btn btn-dark products" name="FREETRIAL">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        $("#btn_Subscribe ,#btn_Subscribe2 ,#btn_Subscribe3").on("click", function () {
            var dataValue = $(this).data("value");
            var dataType = $(this).data("type");

            $("#amount").val(dataValue);
            $("#type").val(dataType);
            $("#modal-payment").modal("show");
        });
    });

    // Get a reference to the file input element
    const fileInput = $("#image");

    // Get a reference to the image preview element
    const imagePreview = $("#image-preview");

    // Add an event listener to the file input
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

</html>
