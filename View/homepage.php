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
    <?php include("../layouts/head.layout.php")?>
    <title>Homepage</title>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details','id',$_SESSION['id']));
    $users = mysqli_fetch_assoc(getrecord('users','id',$_SESSION['id']));
    if ($users['isVerify'] == 'No'){
        header("Location: verify.php");
    }
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <div class="intro-slider-container">
                <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl" data-owl-options='{
                        "dots": false,
                        "nav": false, 
                        "responsive": {
                            "992": {
                                "nav": true
                            }
                        }
                    }'>
                    <div class="intro-slide" style="background-image: url(../assets/images/demos/demo-6/slider/slide-1.jpg);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle text-white">You're Looking Good</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title text-white">New Lookbook</h1><!-- End .intro-title -->

                            <a href="category.html" class="btn btn-outline-white-4">
                                <span>Discover More</span>
                            </a>
                        </div><!-- End .intro-content -->
                    </div><!-- End .intro-slide -->

                    <div class="intro-slide" style="background-image: url(../assets/images/demos/demo-6/slider/slide-2.jpg);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle text-white">Don’t Miss</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title text-white">Mysrety Deals</h1><!-- End .intro-title -->

                            <a href="category.html" class="btn btn-outline-white-4">
                                <span>Discover More</span>
                            </a>
                        </div><!-- End .intro-content -->
                    </div><!-- End .intro-slide -->
                </div><!-- End .intro-slider owl-carousel owl-theme -->

                <span class="slider-loader"></span><!-- End .slider-loader -->
            </div><!-- End .intro-slider-container -->

            <div class="mb-5"></div><!-- End .mb-5 -->
            <div class="container">
                <div class="heading heading-center mb-3">
                    <h2 class="title">Recently Added product</h2><!-- End .title -->

                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        
                        <li class="nav-item">
                            <a class="nav-link active" id="trending-all-link" data-toggle="tab" href="#trending-all-tab" role="tab" aria-controls="trending-all-tab" aria-selected="true">All</a>
                        </li>
                        <?php 
                        $categories = getallrecord('categories');
                        while($category = mysqli_fetch_assoc($categories)){?>
                            <li class="nav-item">
                                <a class="nav-link" id="trending-women-link" data-toggle="tab" href="#<?=$category['category']?>" role="tab" aria-controls="<?=$category['category']?>" aria-selected="false"><?=$category['category']?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="tab-content tab-content-carousel">
                    <div class="tab-pane p-0 fade show active" id="trending-all-tab" role="tabpanel" aria-labelledby="trending-all-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $all = getallrecord('products');

                            if ($all) {
                                while ($categoryAll1 = mysqli_fetch_assoc($all)) {
                                    $categoryAll = mysqli_fetch_assoc(getrecord('product_details','id',$categoryAll1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryAll1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryAll1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryAll1['user_id']));
                                    if($user1['isSubscribe'] == 'Yes'){
                                        ?>
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <a href="product.html">
                                                    <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                </a>
                                                <div class="product-action">
                                                    
                                                        <a href="productDetails.php?product_id=<?php echo $categoryAll['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                    
                                                    
                                                    
                                                    
                                                </div><!-- End .product-action -->
                                            </figure><!-- End .product-media -->
                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="#"><?=$categoryAll['category']?></a>
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a href="product.html"><?=$categoryAll['product_name']?></a></h3><!-- End .product-title -->
                                                <div class="product-price">
                                                    P<?php echo minPrice($categoryAll['id'])['price']?> - P<?php echo maxPrice($categoryAll['id'])['price']?>
                                                </div><!-- End .product-price -->
                                            </div><!-- End .product-body -->
                                        </div>
                                    <?php } ?>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane p-0 fade" id="Dresses" role="tabpanel" aria-labelledby="trending-all-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $dresses = getrecord('product_details', 'category', 'Dresses');

                            if ($dresses) {
                                mysqli_data_seek($all, 0);
                                while ($categoryDress1 = mysqli_fetch_assoc($all)) {
                                    $categoryDress = mysqli_fetch_assoc(getrecord('product_details','id',$categoryDress1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryDress1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryDress1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryDress1['user_id']));
                                        if($user1['isSubscribe'] == 'Yes'){
                                            if($categoryDress['category'] == 'Dresses'){
                                                ?>
                                                <div class="product product-7 text-center">
                                                    <figure class="product-media">
                                                        <a href="product.html">
                                                            <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                        </a>
                                                        <div class="product-action">
                                                            
                                                                <a href="productDetails.php?product_id=<?php echo $categoryDress['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                            
                                                            
                                                            
                                                        </div><!-- End .product-action -->
                                                    </figure><!-- End .product-media -->

                                                    <div class="product-body">
                                                        <div class="product-cat">
                                                            <a href="#"><?=$categoryDress['category']?></a>
                                                        </div><!-- End .product-cat -->
                                                        <h3 class="product-title"><a href="product.html"><?=$categoryDress['product_name']?></a></h3><!-- End .product-title -->
                                                        <div class="product-price">
                                                            P<?php echo minPrice($categoryDress['id'])['price']?> - P<?php echo maxPrice($categoryDress['id'])['price']?>
                                                        </div><!-- End .product-price -->
                                                    </div><!-- End .product-body -->
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                <?php } ?>   
                            <?php  } else { ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane p-0 fade" id="T-Shirts" role="tabpanel" aria-labelledby="trending-all-link">
                         <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $dresses = getrecord('product_details', 'category', 'T-Shirts');

                            if ($dresses) {
                                mysqli_data_seek($all, 0);
                                while ($categoryDress1 = mysqli_fetch_assoc($all)) {
                                    $categoryDress = mysqli_fetch_assoc(getrecord('product_details','id',$categoryDress1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryDress1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryDress1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryDress1['user_id']));
                                        if($user1['isSubscribe'] == 'Yes'){
                                            if($categoryDress['category'] == 'T-Shirts'){
                                                ?>
                                                <div class="product product-7 text-center">
                                                    <figure class="product-media">
                                                        <a href="product.html">
                                                            <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                        </a>
                                                        <div class="product-action">
                                                            
                                                                <a href="productDetails.php?product_id=<?php echo $categoryDress['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                            
                                                            
                                                            
                                                        </div><!-- End .product-action -->
                                                    </figure><!-- End .product-media -->

                                                    <div class="product-body">
                                                        <div class="product-cat">
                                                            <a href="#"><?=$categoryDress['category']?></a>
                                                        </div><!-- End .product-cat -->
                                                        <h3 class="product-title"><a href="product.html"><?=$categoryDress['product_name']?></a></h3><!-- End .product-title -->
                                                        <div class="product-price">
                                                            P<?php echo minPrice($categoryDress['id'])['price']?> - P<?php echo maxPrice($categoryDress['id'])['price']?>
                                                        </div><!-- End .product-price -->
                                                    </div><!-- End .product-body -->
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                <?php } ?>   
                            <?php  } else { ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane p-0 fade" id="Jeans" role="tabpanel" aria-labelledby="trending-all-link">
                         <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $dresses = getrecord('product_details', 'category', 'Jeans');

                            if ($dresses) {
                                mysqli_data_seek($all, 0);
                                while ($categoryDress1 = mysqli_fetch_assoc($all)) {
                                    $categoryDress = mysqli_fetch_assoc(getrecord('product_details','id',$categoryDress1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryDress1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryDress1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryDress1['user_id']));
                                        if($user1['isSubscribe'] == 'Yes'){
                                            if($categoryDress['category'] == 'Jeans'){
                                                ?>
                                                <div class="product product-7 text-center">
                                                    <figure class="product-media">
                                                        <a href="product.html">
                                                            <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                        </a>
                                                        <div class="product-action">
                                                            
                                                                <a href="productDetails.php?product_id=<?php echo $categoryDress['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                            
                                                            
                                                            
                                                        </div><!-- End .product-action -->
                                                    </figure><!-- End .product-media -->

                                                    <div class="product-body">
                                                        <div class="product-cat">
                                                            <a href="#"><?=$categoryDress['category']?></a>
                                                        </div><!-- End .product-cat -->
                                                        <h3 class="product-title"><a href="product.html"><?=$categoryDress['product_name']?></a></h3><!-- End .product-title -->
                                                        <div class="product-price">
                                                            P<?php echo minPrice($categoryDress['id'])['price']?> - P<?php echo maxPrice($categoryDress['id'])['price']?>
                                                        </div><!-- End .product-price -->
                                                    </div><!-- End .product-body -->
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                <?php } ?>   
                            <?php  } else { ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane p-0 fade" id="Jackets" role="tabpanel" aria-labelledby="trending-all-link">
                         <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $dresses = getrecord('product_details', 'category', 'Jackets');

                            if ($dresses) {
                                mysqli_data_seek($all, 0);
                                while ($categoryDress1 = mysqli_fetch_assoc($all)) {
                                    $categoryDress = mysqli_fetch_assoc(getrecord('product_details','id',$categoryDress1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryDress1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryDress1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryDress1['user_id']));
                                        if($user1['isSubscribe'] == 'Yes'){
                                            if($categoryDress['category'] == 'Jackets'){
                                                ?>
                                                <div class="product product-7 text-center">
                                                    <figure class="product-media">
                                                        <a href="product.html">
                                                            <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                        </a>
                                                        <div class="product-action">
                                                            
                                                                <a href="productDetails.php?product_id=<?php echo $categoryDress['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                            
                                                            
                                                            
                                                        </div><!-- End .product-action -->
                                                    </figure><!-- End .product-media -->

                                                    <div class="product-body">
                                                        <div class="product-cat">
                                                            <a href="#"><?=$categoryDress['category']?></a>
                                                        </div><!-- End .product-cat -->
                                                        <h3 class="product-title"><a href="product.html"><?=$categoryDress['product_name']?></a></h3><!-- End .product-title -->
                                                        <div class="product-price">
                                                            P<?php echo minPrice($categoryDress['id'])['price']?> - P<?php echo maxPrice($categoryDress['id'])['price']?>
                                                        </div><!-- End .product-price -->
                                                    </div><!-- End .product-body -->
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                <?php } ?>   
                            <?php  } else { ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane p-0 fade" id="Bag" role="tabpanel" aria-labelledby="trending-all-link">
                         <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $dresses = getrecord('product_details', 'category', 'Bag');

                            if ($dresses) {
                                mysqli_data_seek($all, 0);
                                while ($categoryDress1 = mysqli_fetch_assoc($all)) {
                                    $categoryDress = mysqli_fetch_assoc(getrecord('product_details','id',$categoryDress1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryDress1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryDress1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryDress1['user_id']));
                                        if($user1['isSubscribe'] == 'Yes'){
                                            if($categoryDress['category'] == 'Bag'){
                                                ?>
                                                <div class="product product-7 text-center">
                                                    <figure class="product-media">
                                                        <a href="product.html">
                                                            <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                        </a>
                                                        <div class="product-action">
                                                            
                                                                <a href="productDetails.php?product_id=<?php echo $categoryDress['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                            
                                                            
                                                            
                                                        </div><!-- End .product-action -->
                                                    </figure><!-- End .product-media -->

                                                    <div class="product-body">
                                                        <div class="product-cat">
                                                            <a href="#"><?=$categoryDress['category']?></a>
                                                        </div><!-- End .product-cat -->
                                                        <h3 class="product-title"><a href="product.html"><?=$categoryDress['product_name']?></a></h3><!-- End .product-title -->
                                                        <div class="product-price">
                                                            P<?php echo minPrice($categoryDress['id'])['price']?> - P<?php echo maxPrice($categoryDress['id'])['price']?>
                                                        </div><!-- End .product-price -->
                                                    </div><!-- End .product-body -->
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                <?php } ?>   
                            <?php  } else { ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane p-0 fade" id="Sportswears" role="tabpanel" aria-labelledby="trending-all-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $dresses = getrecord('product_details', 'category', 'Sportswears');

                            if ($dresses) {
                                mysqli_data_seek($all, 0);
                                while ($categoryDress1 = mysqli_fetch_assoc($all)) {
                                    $categoryDress = mysqli_fetch_assoc(getrecord('product_details','id',$categoryDress1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryDress1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryDress1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryDress1['user_id']));
                                        if($user1['isSubscribe'] == 'Yes'){
                                            if($categoryDress['category'] == 'Sportswears'){
                                                ?>
                                                <div class="product product-7 text-center">
                                                    <figure class="product-media">
                                                        <a href="product.html">
                                                            <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                        </a>
                                                        <div class="product-action">
                                                            
                                                                <a href="productDetails.php?product_id=<?php echo $categoryDress['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                            
                                                            
                                                            
                                                        </div><!-- End .product-action -->
                                                    </figure><!-- End .product-media -->

                                                    <div class="product-body">
                                                        <div class="product-cat">
                                                            <a href="#"><?=$categoryDress['category']?></a>
                                                        </div><!-- End .product-cat -->
                                                        <h3 class="product-title"><a href="product.html"><?=$categoryDress['product_name']?></a></h3><!-- End .product-title -->
                                                        <div class="product-price">
                                                            P<?php echo minPrice($categoryDress['id'])['price']?> - P<?php echo maxPrice($categoryDress['id'])['price']?>
                                                        </div><!-- End .product-price -->
                                                    </div><!-- End .product-body -->
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                <?php } ?>   
                            <?php  } else { ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane p-0 fade" id="Shoes" role="tabpanel" aria-labelledby="trending-all-link">
                         <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $dresses = getrecord('product_details', 'category', 'Shoes');

                            if ($dresses) {
                                mysqli_data_seek($all, 0);
                                while ($categoryDress1 = mysqli_fetch_assoc($all)) {
                                    $categoryDress = mysqli_fetch_assoc(getrecord('product_details','id',$categoryDress1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryDress1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryDress1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryDress1['user_id']));
                                        if($user1['isSubscribe'] == 'Yes'){
                                            if($categoryDress['category'] == 'Shoes'){
                                                ?>
                                                <div class="product product-7 text-center">
                                                    <figure class="product-media">
                                                        <a href="product.html">
                                                            <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                        </a>
                                                        <div class="product-action">
                                                            
                                                                <a href="productDetails.php?product_id=<?php echo $categoryDress['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                            
                                                            
                                                            
                                                        </div><!-- End .product-action -->
                                                    </figure><!-- End .product-media -->

                                                    <div class="product-body">
                                                        <div class="product-cat">
                                                            <a href="#"><?=$categoryDress['category']?></a>
                                                        </div><!-- End .product-cat -->
                                                        <h3 class="product-title"><a href="product.html"><?=$categoryDress['product_name']?></a></h3><!-- End .product-title -->
                                                        <div class="product-price">
                                                            P<?php echo minPrice($categoryDress['id'])['price']?> - P<?php echo maxPrice($categoryDress['id'])['price']?>
                                                        </div><!-- End .product-price -->
                                                    </div><!-- End .product-body -->
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                <?php } ?>   
                            <?php  } else { ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane p-0 fade" id="Jumpers" role="tabpanel" aria-labelledby="trending-all-link">
                          <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            <?php 
                            $dresses = getrecord('product_details', 'category', 'Jumpers');

                            if ($dresses) {
                                mysqli_data_seek($all, 0);
                                while ($categoryDress1 = mysqli_fetch_assoc($all)) {
                                    $categoryDress = mysqli_fetch_assoc(getrecord('product_details','id',$categoryDress1['id']));
                                    $image = mysqli_fetch_assoc(getrecord('product_images','product_id',$categoryDress1['id']));
                                    $product = mysqli_fetch_assoc(getrecord('products','id',$categoryDress1['id']));
                                    $user1 = mysqli_fetch_assoc(getrecord('users','id',$categoryDress1['user_id']));
                                        if($user1['isSubscribe'] == 'Yes'){
                                            if($categoryDress['category'] == 'Jumpers'){
                                                ?>
                                                <div class="product product-7 text-center">
                                                    <figure class="product-media">
                                                        <a href="product.html">
                                                            <img src="<?=$image['image']?>" alt="Product image" class="product-image" style="height:300px;">
                                                        </a>
                                                        <div class="product-action">
                                                            
                                                                <a href="productDetails.php?product_id=<?php echo $categoryDress['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                            
                                                            
                                                            
                                                        </div><!-- End .product-action -->
                                                    </figure><!-- End .product-media -->

                                                    <div class="product-body">
                                                        <div class="product-cat">
                                                            <a href="#"><?=$categoryDress['category']?></a>
                                                        </div><!-- End .product-cat -->
                                                        <h3 class="product-title"><a href="product.html"><?=$categoryDress['product_name']?></a></h3><!-- End .product-title -->
                                                        <div class="product-price">
                                                            P<?php echo minPrice($categoryDress['id'])['price']?> - P<?php echo maxPrice($categoryDress['id'])['price']?>
                                                        </div><!-- End .product-price -->
                                                    </div><!-- End .product-body -->
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                <?php } ?>   
                            <?php  } else { ?>
                                <div class="text-center">
                                    No Products Added Yet in This Category
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main><!-- End .main -->
        <?php include("../layouts/footer.layout.php")?>
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery.hoverIntent.min.js"></script>
    <script src="../assets/js/jquery.waypoints.min.js"></script>
    <script src="../assets/js/superfish.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/bootstrap-input-spinner.js"></script>
    <script src="../assets/js/jquery.plugin.min.js"></script>
    <script src="../assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../assets/js/jquery.countdown.min.js"></script>
    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/demos/demo-6.js"></script>
</body>


<!-- molla/index-6.html  22 Nov 2019 09:56:39 GMT -->
</html>