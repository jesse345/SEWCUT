<?php
include("../Model/db.php");
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$dress = countCategory("Dresses");
$tshirt = countCategory("T-Shirts");
$jeans = countCategory("Jeans");
$jacket = countCategory("Jackets");
$bag = countCategory("Bag");
$sportswear = countCategory("Sportswears");
$shoes = countCategory("Shoes");
$jumper = countCategory("Jumpers");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.layout.php")?>
    <title>My Product</title>
</head>
<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details','id',$_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav breadcrumb-with-filter">
                <div class="container">
                	
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="page-content">
            	<div class="categories-page">
	                <div class="container">
	                	<div class="row">
	                		<div class="col-md-6">
	                			<div class="banner banner-cat banner-badge">
		                			<a href="category.php?category=Dresses">
		                				<img src="../assets/images/category/boxed/banner-1.jpg" alt="Banner">
		                			</a>

		                			<a class="banner-link"  href="category.php?category=Dresses">
		                				<h3 class="banner-title">Dresses</h3><!-- End .banner-title -->
                                        
		                				<h4 class="banner-subtitle"><?php echo $dress['category_count']; ?> Products</h4>
		                				<span class="banner-link-text">Shop Now</span>
		                			</a><!-- End .banner-link -->
	                			</div><!-- End .banner -->

	                			<div class="banner banner-cat banner-badge">
		                			<a href="category.php?category=Jackets">
		                				<img src="../assets/images/category/boxed/banner-2.jpg" alt="Banner">
		                			</a>

		                			<a class="banner-link" href="category.php?category=Jackets">
		                				<h3 class="banner-title">Jackets</h3><!-- End .banner-title -->
		                				<h4 class="banner-subtitle"><?php echo $jacket['category_count']; ?> Products</h4><!-- End .banner-subtitle -->
		                				<span class="banner-link-text">Shop Now</span>
		                			</a><!-- End .banner-link -->
	                			</div><!-- End .banner -->
	                		</div><!-- End .col-md-6 -->

	                		<div class="col-md-6">
	                			<div class="row">
	                				<div class="col-sm-6">
	                					<div class="banner banner-cat banner-badge">
				                			<a href="category.php?category=T-Shirts">
				                				<img src="../assets/images/category/boxed/banner-3.jpg" alt="Banner">
				                			</a>

				                			<a class="banner-link" href="category.php?category=T-Shirts">
				                				<h3 class="banner-title">T-shirts</h3><!-- End .banner-title -->
				                				<h4 class="banner-subtitle"><?php echo $tshirt['category_count']; ?> Products</h4><!-- End .banner-subtitle -->
				                				<span class="banner-link-text">Shop Now</span>
				                			</a><!-- End .banner-link -->
			                			</div><!-- End .banner -->
	                				</div><!-- End .col-sm-6 -->

	                				<div class="col-sm-6">
	                					<div class="banner banner-cat banner-badge">
				                			<a href="category.php?category=Jeans">
				                				<img src="../assets/images/category/boxed/banner-4.jpg" alt="Banner">
				                			</a>

				                			<a class="banner-link" href="category.php?category=Jeans">
				                				<h3 class="banner-title">Jeans</h3><!-- End .banner-title -->
				                				<h4 class="banner-subtitle"><?php echo $jeans['category_count']; ?> Products</h4><!-- End .banner-subtitle -->
				                				<span class="banner-link-text">Shop Now</span>
				                			</a><!-- End .banner-link -->
			                			</div><!-- End .banner -->
	                				</div><!-- End .col-sm-6 -->
	                			</div><!-- End .row -->

	                			<div class="banner banner-cat banner-badge">
		                			<a href="category.php?category=Bag">
		                				<img src="..//assets/images/category/boxed/banner-5.jpg" alt="Banner">
		                			</a>

		                			<a class="banner-link" href="category.php?category=Bag">
		                				<h3 class="banner-title">Bags</h3><!-- End .banner-title -->
		                				<h4 class="banner-subtitle"><?php echo $bag['category_count']; ?> Products</h4><!-- End .banner-subtitle -->
		                				<span class="banner-link-text">Shop Now</span>
		                			</a><!-- End .banner-link -->
	                			</div><!-- End .banner -->
	                		</div><!-- End .col-md-6 -->

	                		<div class="col-sm-6 col-md-3">
	                			<div class="banner banner-cat banner-badge">
		                			<a href="category.php?category=Sportswears">
		                				<img src="../assets/images/category/boxed/banner-6.jpg" alt="Banner">
		                			</a>

		                			<a class="banner-link" href="category.php?category=Sportswears">
		                				<h3 class="banner-title">Sportwear</h3><!-- End .banner-title -->
		                				<h4 class="banner-subtitle"><?php echo $sportswear['category_count']; ?> Products</h4><!-- End .banner-subtitle -->
		                				<span class="banner-link-text">Shop Now</span>
		                			</a><!-- End .banner-link -->
	                			</div><!-- End .banner -->
	                		</div><!-- End .col-md-3 -->

	                		<div class="col-sm-6 col-md-3 order-md-last">
	                			<div class="banner banner-cat banner-badge">
		                			<a href="category.php?category=Jumpers">
		                				<img src="../assets/images/category/boxed/banner-8.jpg" alt="Banner">
		                			</a>

		                			<a class="banner-link" href="category.php?category=Jumpers">
		                				<h3 class="banner-title">Jumpers</h3><!-- End .banner-title -->
		                				<h4 class="banner-subtitle"><?php echo $jumper['category_count']; ?> Products</h4><!-- End .banner-subtitle -->
		                				<span class="banner-link-text">Shop Now</span>
		                			</a><!-- End .banner-link -->
	                			</div><!-- End .banner -->
	                		</div><!-- End .col-md-3 -->

	                		<div class="col-md-6">
	                			<div class="banner banner-cat banner-badge">
		                			<a href="category.php?category=Shoes">
		                				<img src="../assets/images/category/boxed/banner-7.jpg" alt="Banner">
		                			</a>

		                			<a class="banner-link" href="category.php?category=Shoes">
		                				<h3 class="banner-title">Shoes</h3><!-- End .banner-title -->
		                				<h4 class="banner-subtitle"><?php echo $shoes['category_count']; ?> Products</h4><!-- End .banner-subtitle -->
		                				<span class="banner-link-text">Shop Now</span>
		                			</a><!-- End .banner-link -->
	                			</div><!-- End .banner -->
	                		</div><!-- End .col-md-6 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .categories-page -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php include("../layouts/jsfile.layout.php"); ?>
</body>
</html>