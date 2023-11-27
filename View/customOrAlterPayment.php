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
        .form-control {
            border: 1px solid #000;
            color: #000;
        }
    </style>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $data = mysqli_fetch_assoc(getrecord('shop_customoralter','id',$_GET['shop_customOrAlter']));
    $seller_data = mysqli_fetch_assoc(getRecentShippingAddress('shop_seller_paymentinfo', 'shop_customoralter_id', $data['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php");
        ?>
        <main class="main mb-15">
            <nav aria-label="breadcrumb" class="breadcrumb-nav breadcrumb-with-filter">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="index.php">Custom Or Alter Transaction</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment</li>
                    </ol>
                </div><!-- End .container -->
            </nav>
            <div style="display: flex; justify-content: center; align-items: center;">
                <form action="../Controller/shopController.php" method="POST" enctype="multipart/form-data">
                    <!-- Your form fields here -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" name="custom_alter_id" value="<?=$_GET['shop_customOrAlter']?>">
                                <label for="email">Gcash Name</label>
                                <input type="text" class="form-control" value="<?= $seller_data['gcash_name'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Gcash Number</label>
                                <input type="text" class="form-control" value="<?= $seller_data['gcash_number'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Total Amount</label>
                        <input type="text" class="form-control" name="price" value="<?=$data['price']?>" readonly>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image[]" id="imageInput" accept="image/*" multiple required>
                    </div>
                    <div class="preview d-flex" id="imagePreviewContainer">
                        <!-- Preview images will be added here -->
                    </div>
                    <div class="form-group">
                        <label for="email">Reference number</label>
                        <input type="text" class="form-control" name="reference_number"
                            placeholder="Enter Reference number" required>
                    </div>
                    <button type="submit" name="CUSTOMORALTER_PAY" class="btn btn-primary float-right">Submit</button>
                </form>
            </div>
        </main><!-- End .main -->
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php include("../layouts/jsfile.layout.php"); ?>
</body>
<script>
     const imageInput = document.getElementById('imageInput');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');

    imageInput.addEventListener('change', function (e) {
        // Clear existing preview images
        imagePreviewContainer.innerHTML = '';

        if (e.target.files.length === 0) {
            return;
        }

        // Loop through all selected files
        for (let i = 0; i < e.target.files.length; i++) {
            let file = e.target.files[i];
            let url = URL.createObjectURL(file);

            // Create an image element for each file
            let imgElement = document.createElement('img');
            imgElement.src = url;
            imgElement.alt = 'Image Preview';
            imgElement.style.height = '140px';

            // Append the image element to the preview container
            imagePreviewContainer.appendChild(imgElement);
        }
    });
</script>

</html>
