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
        .product-image {
            height: 250px !important;
        }
    </style>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $user1 = mysqli_fetch_assoc(getrecord('shops', 'id', $_GET['shop_id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                        <li class="breadcrumb-item"><a href="storeShop.php?shop_id=<?=$_GET['shop_id']?>"> <?= $user1['shop_name'] ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Alter Product
                        </li>
                        
                    </ol>
                    
                </div><!-- End .container-fluid -->
            </nav><!-- End .breadcrumb-nav -->
        </main><!-- End .main -->
        <div class="container">
            <form id="multiPageForm">
                <div id="page1" class="form-page">
                    <!-- Page 1 content goes here -->
                    <div class="form-group">
                    <label for="field1">Field 1:</label>
                    <input type="text" class="form-control">
                    </div>
                    <button type="button" class="btn btn-primary" id="Page1">Next</button>
                </div>

                <div id="page2" class="form-page d-none">
                    <!-- Page 2 content goes here -->
                    <div class="form-group">
                    <label for="field2">Field 2:</label>
                    <input type="text" class="form-control" id="field2" name="field2">
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="prevPage(1)">Previous</button>
                    <button type="button" class="btn btn-primary" onclick="nextPage(3)">Next</button>
                </div>

                <div id="page3" class="form-page d-none">
                    <!-- Page 3 content goes here -->
                    <div class="form-group">
                    <label for="field3">Field 3:</label>
                    <input type="text" class="form-control" id="field3" name="field3">
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="prevPage(2)">Previous</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
    <script>
    function nextPage(page) {
        $(`#page${page - 1}`).addClass('d-none');
        $(`#page${page}`).removeClass('d-none');
    }

    function prevPage(page) {
        $(`#page${page}`).show();
        $(`#page${page - 1}`).hide();
    }
    $('.product-gallery-item').on('click', function (e) {
            $('#product-zoom-gallery').find('a').removeClass('active');
            $(this).addClass('active');

            e.preventDefault();
        });
</script>


</body>

</html>
