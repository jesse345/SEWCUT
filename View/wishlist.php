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
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <table class="table table-wishlist table-mobile">
                        <thead>
                            <tr>
                                <th>Product and Details</th>
                                <th>Price</th>
                                <th>Stock Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $wishlistUser = getWishlist($_SESSION['id']);
                            while ($user = mysqli_fetch_assoc($wishlistUser)):
                                $productImages = mysqli_fetch_assoc(displayDetails('product_images', 'product_id', $user['product_id']));
                                $product_details = mysqli_fetch_assoc(displayDetails('product_details', 'id', $user['product_id']));
                                $product_details_etc = mysqli_fetch_assoc(displayDetails('product_details_etc', 'product_id', $user['product_id']));
                                ?>
                                <tr>
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="#">
                                                    <img src="<?= $productImages['image'] ?>" alt="Product image">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="#">
                                                    <?= $product_details['product_name'] ?>
                                                </a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">
                                        <?= $product_details_etc['price'] ?>
                                    </td>
                                    <?php if ($product_details_etc['quantity'] > 1) { ?>
                                        <td class="stock-col"><span class="in-stock">In stock</span></td>
                                        <td class="action-col">
                                            <a href="productDetails.php?product_id=<?= $user['product_id'] ?>"
                                                class="btn btn-block btn-outline-primary-2"><i class="icon-cart-plus"></i>Add to
                                                Cart
                                            </a>
                                        </td>
                                    <?php } else { ?>
                                        <td class="stock-col"><span class="out-of-stock">Out of stock</span></td>
                                        <td class="action-col">
                                            <button class="btn btn-block btn-outline-primary-2 disabled">Out of Stock</button>
                                        </td>
                                    <?php } ?>
                                    <form action="../Controller/wishlistController.php" method="POST">
                                        <input type="hidden" name="wishlist_id" value="<?= $user['id'] ?>">
                                        <td class="remove-col"><button type="submit" name="REMOVETOWISHLIST"
                                                class="btn-remove"><i class="icon-close"></i></button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table><!-- End .table table-wishlist -->
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

</html>
