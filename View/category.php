<?php
include("../Model/db.php");
session_start();
error_reporting();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.layout.php")?>
    <title>My Product</title>
    <style>
        .product-image{
            height:250px!important;
        }
    </style>
</head>
<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details','id',$_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container-fluid">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="ShopCategories.php">Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=$_GET['category']?></li>
                    </ol>
                </div><!-- End .container-fluid -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container-fluid">
        			

                    <div class="products">
                        <div class="row">
                            <?php $product = displayProduct('products');
                            while($products = mysqli_fetch_assoc($product)): 
                                $productImage = mysqli_fetch_assoc(displayDetails('product_images','product_id',$products['id']));
                                $productDetails = mysqli_fetch_assoc(displayDetails('product_details','id',$products['id'])); 
                                $minPrice = minPrice($products['id']); 
                                if($productDetails['category'] == $_GET['category']){?>
                                <div class="col-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                                    <div class="product">
                                        <figure class="product-media">
                                            <?php if($products['inShop'] == 'Yes'){?>
                                                <span class="product-label label-new">Shop</span>
                                            <?php } ?>
                                            <a href="#">
                                                <img src="<?php echo $productImage['image']?>" alt="Product image" class="product-image">
                                            </a>
                                            <?php if($products['user_id'] != $_SESSION['id']){?>
                                                <div class="product-action action-icon-top" style="display:flex;justify-content:center;align-items:center;">
                                                    <form action="">
                                                        <a href="productDetails.php?product_id=<?php echo $products['id']?>" class="btn-product btn-cart" name="ADDCART" style="border:none;background-color:transparent;margin-right:10px;" title="Add to Cart"><span>Add to Cart</span></a>
                                                    </form>
                                                    <form action="../Controller/wishlistController.php" method="POST">
                                                        <?php $checkWishlist = getRecordWishlist('wishlists',$_SESSION['id'], $products['id']);
                                                        if (mysqli_num_rows($checkWishlist) > 0) {
                                                        ?>
                                                            <input type="hidden" name="product_id" value="<?php echo $products['id']?>">
                                                            <button class="btn-product btn-wishlist" name="REMOVEWISHLIST" style="border:none;background-color:transparent;" title="Remove From Wishlist"><span>Remove From Wishlist</span></button>
                                                        <?php } else {?>
                                                            <input type="hidden" name="product_id" value="<?php echo $products['id']?>">
                                                            <button class="btn-product btn-wishlist" name="ADDWISHLIST" style="border:none;background-color:transparent;" title="Add to Wishlist"><span>Add to Wishlist</span></button>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            <?php } else {?>
                                                <div class="product-action action-icon-top">
                                                    <a href="myProduct.php" class="btn-product"><span>Manager My Product</span></a>
                                                </div>
                                            <?php } ?>
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <div class="product-cat">
                                                <a href="#"><?php echo $productDetails['category']?></a>
                                            </div><!-- End .product-cat -->
                                            <h3 class="product-title"><a href="product.html"><?php echo $productDetails['product_name']?></a></h3><!-- End .product-title -->
                                            <div class="product-price">

                                                P<?php echo minPrice($products['id'])['price']?> - P<?php echo maxPrice($products['id'])['price']?>
                                                
                                            </div><!-- End .product-price -->
                                            
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                                </div>
                                <?php } ?>
                            <?php endwhile; ?>
                        </div><!-- End .row -->                 
                    </div><!-- End .products -->

                   
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