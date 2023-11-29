<?php
include("../Model/db.php");
session_start();
error_reporting(0);

?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <?php include("../layouts/head.layout.php")?>
    <title>Homepage</title>
</head>
<body>
    <div class="page-wrapper">
        
        <?php 
        if(isset($_SESSION['id'])){
            $user = mysqli_fetch_assoc(getrecord('user_details','id',$_SESSION['id']));
            $users = mysqli_fetch_assoc(getrecord('users','id',$_SESSION['id']));
            if ($users['isVerify'] == 'No'){
                header("Location: verify.php");
            }
             include("../layouts/header_layout.php");
        } else{
            include("../layouts/header_layout1.php"); 
        }
        ?>
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
    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active">
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="category.html">Shop</a>
                    </li>
                    <li>
                        <a href="product.html" class="sf-with-ul">Product</a>
                    </li>
                    <li>
                        <a href="#">Pages</a>
                        <ul>
                            <li>
                                <a href="about.html">About</a>

                                <ul>
                                    <li><a href="about.html">About 01</a></li>
                                    <li><a href="about-2.html">About 02</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="contact.html">Contact</a>

                                <ul>
                                    <li><a href="contact.html">Contact 01</a></li>
                                    <li><a href="contact-2.html">Contact 02</a></li>
                                </ul>
                            </li>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="faq.html">FAQs</a></li>
                            <li><a href="404.html">Error 404</a></li>
                            <li><a href="coming-soon.html">Coming Soon</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="blog.html">Blog</a>

                        <ul>
                            <li><a href="blog.html">Classic</a></li>
                            <li><a href="blog-listing.html">Listing</a></li>
                            <li>
                                <a href="#">Grid</a>
                                <ul>
                                    <li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
                                    <li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
                                    <li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
                                    <li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Masonry</a>
                                <ul>
                                    <li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
                                    <li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
                                    <li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
                                    <li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Mask</a>
                                <ul>
                                    <li><a href="blog-mask-grid.html">Blog mask grid</a></li>
                                    <li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Single Post</a>
                                <ul>
                                    <li><a href="single.html">Default with sidebar</a></li>
                                    <li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
                                    <li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="elements-list.html">Elements</a>
                        <ul>
                            <li><a href="elements-products.html">Products</a></li>
                            <li><a href="elements-typography.html">Typography</a></li>
                            <li><a href="elements-titles.html">Titles</a></li>
                            <li><a href="elements-banners.html">Banners</a></li>
                            <li><a href="elements-product-category.html">Product Category</a></li>
                            <li><a href="elements-video-banners.html">Video Banners</a></li>
                            <li><a href="elements-buttons.html">Buttons</a></li>
                            <li><a href="elements-accordions.html">Accordions</a></li>
                            <li><a href="elements-tabs.html">Tabs</a></li>
                            <li><a href="elements-testimonials.html">Testimonials</a></li>
                            <li><a href="elements-blog-posts.html">Blog Posts</a></li>
                            <li><a href="elements-portfolio.html">Portfolio</a></li>
                            <li><a href="elements-cta.html">Call to Action</a></li>
                            <li><a href="elements-icon-boxes.html">Icon Boxes</a></li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
    <?php 
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    ?>
</body>


<!-- molla/index-6.html  22 Nov 2019 09:56:39 GMT -->
</html>