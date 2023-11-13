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
    <title>My Product</title>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php
        include("../layouts/header_layout.php");
        $products = mysqli_fetch_assoc(displayDetails('products', 'id', $_GET['product_id']));
        $productDetails = mysqli_fetch_assoc(displayDetails('product_details', 'id', $_GET['product_id']));
        $productImages = displayDetails('product_images', 'product_id', $_GET['product_id']);
        $product_details_etc = displayDetails('product_details_etc', 'product_id', $_GET['product_id']);
        ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Info</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery">
                                    <?php
                                    $collectedData = array();
                                    $mainImage = ''; // Initialize a variable for the main image
                                    foreach ($productImages as $i => $image):
                                        $collectedData[] = $image['image'];
                                        $fileExtension = pathinfo($collectedData[$i], PATHINFO_EXTENSION);

                                        // Set the main image if it's an image file
                                        if (in_array($fileExtension, array('jpg', 'jpeg', 'png', 'gif')) && empty($mainImage)) {
                                            $mainImage = $collectedData[$i];
                                        }
                                        ?>
                                    <?php endforeach ?>

                                    <!-- Display the main image -->
                                    <figure class="product-main-image">
                                        <span class="product-label label-sale">Sale</span>
                                        <img id="product-zoom" src="<?php echo $mainImage ?>"
                                            data-zoom-image="<?php echo $mainImage ?>" alt="product image">
                                        <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                            <i class="icon-arrows"></i>
                                        </a>
                                    </figure>

                                    <!-- Display images and videos in the product-zoom-gallery -->
                                    <div id="product-zoom-gallery"
                                        class="product-image-gallery product-gallery-masonry">
                                        <?php for ($i = 1; $i < count($collectedData); $i++): ?>
                                            <?php $fileExtension = pathinfo($collectedData[$i], PATHINFO_EXTENSION); ?>
                                            <?php if (in_array($fileExtension, array('jpg', 'jpeg', 'png', 'gif'))): ?>
                                                <!-- Display images -->
                                                <a class="product-gallery-item" href="#"
                                                    data-image="<?php echo $collectedData[$i] ?>"
                                                    data-zoom-image="<?php echo $collectedData[$i] ?>">
                                                    <img src="<?php echo $collectedData[$i] ?>" alt="product cross">
                                                </a>
                                            <?php else: ?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>


                            </div>

                            <div class="col-md-6">
                                <div class="product-details sticky-content">
                                    <h1 class="product-title">
                                        <?php echo $productDetails['product_name'] ?>
                                    </h1><!-- End .product-title -->

                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <a class="ratings-text" href="#product-accordion" id="review-link">( 2 Reviews
                                            )</a>
                                    </div><!-- End .rating-container -->

                                    <div class="product-price">
                                        <span class="new-price">P
                                            <?php echo minPrice($_GET['product_id'])['price'] ?> - P
                                            <?php echo maxPrice($_GET['product_id'])['price'] ?>
                                        </span>
                                    </div><!-- End .product-price -->

                                    <div class="product-content">
                                        <p>
                                            <?php echo $productDetails['description'] ?>.
                                        </p>
                                    </div><!-- End .product-content -->
                                    <form action="../Controller/cartController.php" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
                                        <input type="hidden" name="product_id"
                                            value="<?php echo $_GET['product_id']; ?>">

                                        <?php $checkCart = getRecordCart('carts', $_SESSION['id'], $_GET['product_id']);
                                        if (mysqli_num_rows($checkCart) > 0) {
                                            ?>
                                            <div class="details-filter-row details-row-size">
                                                <label>Color:</label>
                                                <div class="select-custom">
                                                    <select name="color" id="color" class="form-control"
                                                        data-product-id="<?php echo $_GET['product_id']; ?>">
                                                        <option selected="selected">Select Color</option>
                                                        <?php
                                                        $addedColors = array(); // Initialize an array to keep track of added colors
                                                        foreach ($product_details_etc as $pde):
                                                            $color = $pde['color'];
                                                            if (!in_array($color, $addedColors)) { // Check if color is not already added
                                                                $addedColors[] = $color; // Add the color to the list of added colors
                                                                ?>
                                                                <option value="<?php echo $color ?>">
                                                                    <?php echo $color ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="details-filter-row details-row-size">
                                                <label for="size">Size:</label>
                                                <div class="select-custom">
                                                    <select name="size" id="size" class="form-control">
                                                        <option value="" selected="selected">Select Size</option>
                                                        <?php
                                                        $addedSize = array();
                                                        foreach ($product_details_etc as $pde):
                                                            $size = $pde['size'];
                                                            if (!in_array($size, $addedSize)) {
                                                                $addedSize[] = $size;
                                                                ?>
                                                                <option value="<?php echo $size ?>">
                                                                    <?php echo $size ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="details-filter-row details-row-size">
                                                <label for="qty">Qty:</label>
                                                <div class="product-details-quantity">
                                                    <input type="number" name="quanity" class="form-control" value="1"
                                                        min="1" max="10" step="1" data-decimals="0" required>

                                                </div><!-- End .product-details-quantity -->
                                                <?php $totalQuantiy = sumOfProduct($_GET['product_id']) ?>
                                                <p id="totalQuantity" style="margin-left:25px;">
                                                    <?php echo $totalQuantiy['total']; ?> available pieces
                                                </p>
                                                <p id="newTotal"></p>
                                            </div>
                                            <div class="product-details-action">
                                                <input type="hidden" name="product_id"
                                                    value="<?php echo $_GET['product_id'] ?>">
                                                <button type="submit" name="REMOVECART"
                                                    class="btn-product btn-cart"><span>remove to cart</span></button>
                                            <?php } else { ?>
                                                <div class="details-filter-row details-row-size">
                                                    <label>Color:</label>
                                                    <div class="select-custom">
                                                        <select name="color" id="color" class="form-control"
                                                            data-product-id="<?php echo $_GET['product_id'] ?>" required>
                                                            <option value="" selected="selected">Select Color</option>
                                                            <?php
                                                            $addedColors = array(); // Initialize an array to keep track of added colors
                                                            foreach ($product_details_etc as $pde):
                                                                $color = $pde['color'];
                                                                if (!in_array($color, $addedColors)) { // Check if color is not already added
                                                                    $addedColors[] = $color; // Add the color to the list of added colors
                                                                    ?>
                                                                    <option value="<?php echo $color ?>">
                                                                        <?php echo $color ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                            endforeach;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="details-filter-row details-row-size">
                                                    <label for="size">Size:</label>
                                                    <div class="select-custom">
                                                        <select name="size" id="size" class="form-control" required>
                                                            <option value="" selected="selected">Select Size</option>
                                                            <?php
                                                            $addedSize = array();
                                                            foreach ($product_details_etc as $pde):
                                                                $size = $pde['size'];
                                                                if (!in_array($size, $addedSize)) {
                                                                    $addedSize[] = $size;
                                                                    ?>
                                                                    <option value="<?php echo $size ?>">
                                                                        <?php echo $size ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                            endforeach;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="details-filter-row details-row-size">
                                                    <label for="qty">Qty:</label>
                                                    <div class="product-details-quantity">
                                                        <input type="number" name="quanity" class="form-control" value="1"
                                                            min="1" max="10" step="1" data-decimals="0" required>

                                                    </div><!-- End .product-details-quantity -->
                                                    <?php $totalQuantiy = sumOfProduct($_GET['product_id']) ?>
                                                    <p id="totalQuantity" style="margin-left:25px;">
                                                        <?php echo $totalQuantiy['total']; ?> available pieces
                                                    </p>
                                                    <p id="newTotal"></p>
                                                </div>
                                                <div class="product-details-action">
                                                    <input type="hidden" name="product_id"
                                                        value="<?php echo $_GET['product_id'] ?>">
                                                    <button type="submit" name="ADDTOCART"
                                                        class="btn-product btn-cart"><span>add to cart</span></button>
                                                <?php } ?>
                                    </form>
                                    <form action="../Controller/wishlistController.php" method="POST">
                                        <div class="details-action-wrapper">
                                            <?php $checkWishlist = getRecordWishlist('wishlists', $_SESSION['id'], $_GET['product_id']);
                                            if (mysqli_num_rows($checkWishlist) > 0) {
                                                ?>
                                                <input type="hidden" name="product_id"
                                                    value="<?php echo $_GET['product_id'] ?>">
                                                <a><button class="btn-product btn-wishlist" name="REMOVEWISHLIST"
                                                        style="border:none;background-color:transparent;"
                                                        title="Remove Wishlist"><span>Remove from
                                                            Wishlist</span></button></a>
                                            <?php } else { ?>
                                                <input type="hidden" name="product_id"
                                                    value="<?php echo $_GET['product_id'] ?>">
                                                <a><button class="btn-product btn-wishlist" name="ADDWISHLIST"
                                                        style="border:none;background-color:transparent;"
                                                        title="Wishlist"><span>Add to Wishlist</span></button></a>
                                            <?php } ?>

                                            <a href="chat.php?user=<?php echo $products['user_id']?>" class="btn-product btn-compare" style="margin-left:30px;"
                                                title="Chat Seller"><span>Chat Seller</span></a>
                                        </div><!-- End .details-action-wrapper -->
                                    </form>
                                </div>

                                <div class="accordion accordion-plus product-details-accordion" id="product-accordion">
                                    <div class="card card-box card-sm">
                                        <div class="card-header" id="product-desc-heading">
                                            <h2 class="card-title">
                                                <a class="collapsed" role="button" data-toggle="collapse"
                                                    href="#product-accordion-desc" aria-expanded="false"
                                                    aria-controls="product-accordion-desc">
                                                    Description
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->
                                        <div id="product-accordion-desc" class="collapse"
                                            aria-labelledby="product-desc-heading" data-parent="#product-accordion">
                                            <div class="card-body">
                                                <div class="product-desc-content">
                                                    <p>
                                                        <?php echo $productDetails['description'] ?>.
                                                    </p>
                                                </div><!-- End .product-desc-content -->
                                            </div><!-- End .card-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .card -->

                                    <div class="card card-box card-sm">
                                        <div class="card-header" id="product-info-heading">
                                            <h2 class="card-title">
                                                <a class="collapsed" role="button" data-toggle="collapse"
                                                    href="#product-accordion-info" aria-expanded="false"
                                                    aria-controls="product-accordion-info">
                                                    Additional Information
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->
                                        <div id="product-accordion-info" class="collapse"
                                            aria-labelledby="product-info-heading" data-parent="#product-accordion">
                                            <div class="card-body">
                                                <div class="product-desc-content">
                                                    <p>
                                                    <p>
                                                        <?php echo $productDetails['additional_info'] ?>.
                                                    </p>
                                                    </p>
                                                </div><!-- End .product-desc-content -->
                                            </div><!-- End .card-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .card -->
                                    <div class="card card-box card-sm">
                                        <div class="card-header" id="product-review-heading">
                                            <h2 class="card-title">
                                                <a class="collapsed" role="button" data-toggle="collapse"
                                                    href="#product-accordion-review" aria-expanded="false"
                                                    aria-controls="product-accordion-review">
                                                    <?php 
                                                    $countReview = countReview($_GET['product_id']);
                                                    $f = getrecord('feedbacks','product_id',$_GET['product_id']);
                                                    ?>
                                                    Reviews (<?=$countReview['count_review']?>)
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->
                                        <div id="product-accordion-review" class="collapse"
                                            aria-labelledby="product-review-heading" data-parent="#product-accordion">
                                            <div class="card-body">
                                                <div class="reviews">
                                                    <?php
                                                    while($feedback = mysqli_fetch_assoc($f)){ 
                                                        $fb_user = mysqli_fetch_assoc(getrecord('user_details','id',$feedback['user_id']))
                                                        ?>
                                                        <div class="review">
                                                            <div class="row no-gutters">
                                                                <div class="col-auto">
                                                                    <h4><a href="#"><?=ucfirst($fb_user['firstname']) . ' ' . ucfirst($fb_user['lastname'])?></a></h4>
                                                                    <div class="ratings-container">
                                                                        <div class="ratings">
                                                                            <div class="ratings-val" style="width: 
                                                                                <?php 
                                                                                    if ($feedback['rate'] == 1) {
                                                                                        echo '20%';
                                                                                    } elseif ($feedback['rate'] == 2) {
                                                                                        echo '40%';
                                                                                    } elseif ($feedback['rate'] == 3) {
                                                                                        echo '60%';
                                                                                    } elseif ($feedback['rate'] == 4) {
                                                                                        echo '80%';
                                                                                    } elseif ($feedback['rate'] == 5) {
                                                                                        echo '100%';
                                                                                    } 
                                                                                ?>
                                                                            ;">
                                                                            </div>
                                                                        </div><!-- End .ratings -->
                                                                    </div><!-- End .rating-container -->
                                                                </div><!-- End .col -->
                                                                <div class="col">
                                                                    <div class="review-content mt-3">
                                                                        <p><?=ucfirst($feedback['description'])?></p>
                                                                    </div><!-- End .review-content -->
                                                                </div><!-- End .col-auto -->
                                                            </div><!-- End .row -->
                                                        </div><!-- End .review -->
                                                    <?php } ?>
                                                </div><!-- End .reviews -->
                                            </div><!-- End .card-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .card -->
                                </div><!-- End .accordion -->
                            </div><!-- End .product-details -->
                        </div><!-- End .col-md-6 -->
                    </div><!-- End .row -->
                </div><!-- End .product-details-top -->
                <hr class="mt-3 mb-5">

                <h2 class="title text-center mb-4">Sample Videos</h2>
                <div class="video-container">
                    <?php mysqli_data_seek($productImages, 0); ?>
                    <?php while ($pi = mysqli_fetch_assoc($productImages)):
                        $fileExtension = pathinfo($pi['image'], PATHINFO_EXTENSION); // Corrected the fileExtension
                        if (in_array($fileExtension, array('mp4', 'avi', 'mov'))): ?>
                            <center>
                                <video width="75%" height="80%" controls>
                                    <source src="<?php echo $pi['image'] ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <br>
                            </center>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>


            </div><!-- End .container -->
    </div><!-- End .page-content -->
    </main><!-- End .main -->
    <br>
    <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
</body>
<script>
    $(document).ready(function () {
        $("#color, #size").on("change", function () {

            var totalQuantity = $('#totalQuantity');

            var newTotal = $('#newTotal')
            var selectedColor = $("#color").val();
            var selectedSize = $("#size").val();
            var product_id = $("#color").data("product-id");


            $.ajax({
                url: "../Controller/quantityController.php",
                method: "POST",
                data: { product_id: product_id, color: selectedColor, size: selectedSize },
                success: function (response) {
                    if (response != 0) {
                        $(".btn-increment").show();
                        totalQuantity.text(response + " available pieces").show();
                    } else {
                        $(".btn-increment").hide();
                        totalQuantity.text(response + " available pieces").show();
                    }

                },
                error: function (error) {
                    console.log("Error:", error);
                }
            });

        });
    });
</script>

</html>
