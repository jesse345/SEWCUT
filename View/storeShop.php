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
                <div class="container-fluid">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $user1['shop_name'] ?>
                        </li>
                    </ol>
                </div><!-- End .container-fluid -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container-fluid">
                    <div class="products">
                        <div class="row">
                            <?php
                            $product = displayProductInShop('products', 'user_id', $user1['user_id'], 'Yes');
                            while ($products = mysqli_fetch_assoc($product)):
                                $productImage = mysqli_fetch_assoc(displayDetails('product_images', 'product_id', $products['id']));
                                $productDetails = mysqli_fetch_assoc(displayDetails('product_details', 'id', $products['id']));
                                $minPrice = minPrice($products['id']);
                                ?>
                                <div class="col-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                                    <div class="product">
                                        <figure class="product-media">
                                            <a href="#">
                                                <img src="<?php echo $productImage['image'] ?>" alt="Product image"
                                                    class="product-image">
                                            </a>
                                            <?php if ($products['user_id'] != $_SESSION['id']) { ?>
                                                <div class="product-action action-icon-top"
                                                    style="display:flex;justify-content:center;align-items:center;">
                                                    <form action="">
                                                        <a href="productDetails.php?product_id=<?php echo $products['id'] ?>"
                                                            class="btn-product btn-cart" name="ADDCART"
                                                            style="border:none;background-color:transparent;margin-right:10px;"
                                                            title="Add to Cart"><span>Add to Cart</span></a>
                                                    </form>
                                                    <form action="../Controller/wishlistController.php" method="POST">
                                                        <?php $checkWishlist = getRecordWishlist('wishlists', $_SESSION['id'], $products['id']);
                                                        if (mysqli_num_rows($checkWishlist) > 0) {
                                                            ?>
                                                            <input type="hidden" name="product_id"
                                                                value="<?php echo $products['id'] ?>">
                                                            <button class="btn-product btn-wishlist" name="REMOVEWISHLIST"
                                                                style="border:none;background-color:transparent;"
                                                                title="Remove From Wishlist"><span>Remove From
                                                                    Wishlist</span></button>
                                                        <?php } else { ?>
                                                            <input type="hidden" name="product_id"
                                                                value="<?php echo $products['id'] ?>">
                                                            <button class="btn-product btn-wishlist" name="ADDWISHLIST"
                                                                style="border:none;background-color:transparent;"
                                                                title="Add to Wishlist"><span>Add to Wishlist</span></button>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            <?php } else { ?>
                                                <div class="product-action action-icon-top">
                                                    <a href="myProduct.php" class="btn-product"><span>Manager My
                                                            Product</span></a>
                                                </div>
                                            <?php } ?>
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <div class="product-cat">
                                                <a href="#">
                                                    <?php echo $productDetails['category'] ?>
                                                </a>
                                            </div><!-- End .product-cat -->
                                            <h3 class="product-title"><a href="product.html">
                                                    <?php echo $productDetails['product_name'] ?>
                                                </a></h3><!-- End .product-title -->
                                            <div class="product-price">

                                                P
                                                <?php echo minPrice($products['id'])['price'] ?> - P
                                                <?php echo maxPrice($products['id'])['price'] ?>

                                            </div><!-- End .product-price -->
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: 80%;"></div>
                                                    <!-- End .ratings-val -->
                                                </div><!-- End .ratings -->
                                                <span class="ratings-text">( 11 Reviews )</span>
                                            </div><!-- End .rating-container -->
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                            <?php endwhile; ?>
                        </div><!-- End .row -->
                    </div><!-- End .products -->

                    <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
                    <aside class="sidebar-shop sidebar-filter">
                        <div class="sidebar-filter-wrapper">
                            <div class="widget widget-clean">
                                <label><i class="icon-close"></i>Filters</label>
                                <a href="#" class="sidebar-filter-clear">Clean All</a>
                            </div><!-- End .widget -->
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true"
                                        aria-controls="widget-1">
                                        Category
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        <div class="filter-items filter-items-count">
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-1">
                                                    <label class="custom-control-label" for="cat-1">Dresses</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">3</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-2">
                                                    <label class="custom-control-label" for="cat-2">T-shirts</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">0</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-3">
                                                    <label class="custom-control-label" for="cat-3">Bags</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">4</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-4">
                                                    <label class="custom-control-label" for="cat-4">Jackets</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">2</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-5">
                                                    <label class="custom-control-label" for="cat-5">Shoes</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">2</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-6">
                                                    <label class="custom-control-label" for="cat-6">Jumpers</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">1</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-7">
                                                    <label class="custom-control-label" for="cat-7">Jeans</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">1</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-8">
                                                    <label class="custom-control-label" for="cat-8">Sportwear</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">0</span>
                                            </div><!-- End .filter-item -->
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true"
                                        aria-controls="widget-2">
                                        Size
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-2">
                                    <div class="widget-body">
                                        <div class="filter-items">
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-1">
                                                    <label class="custom-control-label" for="size-1">XS</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-2">
                                                    <label class="custom-control-label" for="size-2">S</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked
                                                        id="size-3">
                                                    <label class="custom-control-label" for="size-3">M</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked
                                                        id="size-4">
                                                    <label class="custom-control-label" for="size-4">L</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-5">
                                                    <label class="custom-control-label" for="size-5">XL</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-6">
                                                    <label class="custom-control-label" for="size-6">XXL</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true"
                                        aria-controls="widget-3">
                                        Colour
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-3">
                                    <div class="widget-body">
                                        <div class="filter-colors">
                                            <a href="#" style="background: #b87145;"><span class="sr-only">Color
                                                    Name</span></a>
                                            <a href="#" style="background: #f0c04a;"><span class="sr-only">Color
                                                    Name</span></a>
                                            <a href="#" style="background: #333333;"><span class="sr-only">Color
                                                    Name</span></a>
                                            <a href="#" class="selected" style="background: #cc3333;"><span
                                                    class="sr-only">Color Name</span></a>
                                            <a href="#" style="background: #3399cc;"><span class="sr-only">Color
                                                    Name</span></a>
                                            <a href="#" style="background: #669933;"><span class="sr-only">Color
                                                    Name</span></a>
                                            <a href="#" style="background: #f2719c;"><span class="sr-only">Color
                                                    Name</span></a>
                                            <a href="#" style="background: #ebebeb;"><span class="sr-only">Color
                                                    Name</span></a>
                                        </div><!-- End .filter-colors -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true"
                                        aria-controls="widget-4">
                                        Brand
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-4">
                                    <div class="widget-body">
                                        <div class="filter-items">
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-1">
                                                    <label class="custom-control-label" for="brand-1">Next</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-2">
                                                    <label class="custom-control-label" for="brand-2">River
                                                        Island</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-3">
                                                    <label class="custom-control-label" for="brand-3">Geox</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-4">
                                                    <label class="custom-control-label" for="brand-4">New
                                                        Balance</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-5">
                                                    <label class="custom-control-label" for="brand-5">UGG</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-6">
                                                    <label class="custom-control-label" for="brand-6">F&F</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-7">
                                                    <label class="custom-control-label" for="brand-7">Nike</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true"
                                        aria-controls="widget-5">
                                        Price
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-5">
                                    <div class="widget-body">
                                        <div class="filter-price">
                                            <div class="filter-price-text">
                                                Price Range:
                                                <span id="filter-price-range"></span>
                                            </div><!-- End .filter-price-text -->

                                            <div id="price-slider"></div><!-- End #price-slider -->
                                        </div><!-- End .filter-price -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </div><!-- End .sidebar-filter-wrapper -->
                    </aside><!-- End .sidebar-filter -->
                </div><!-- End .container-fluid -->
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
