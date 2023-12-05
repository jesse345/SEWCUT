<?php
include("../Model/db.php");
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
error_reporting(0);
$report = mysqli_fetch_assoc(reports($_SESSION['id']));
$currentDateTime = time();

if(strtotime($report['suspension_date']) < $currentDateTime)
    header("location:../View/index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.layout.php")?>
</head>
<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details','id',$_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <header class="header header-6">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <ul class="top-menu top-link-menu d-none d-md-block">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li><a href="tel:#"><i class="icon-phone"></i>Call: 09218455684</a></li>
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="header-dropdown">
                    <form action="../Controller/userController.php" method="POST">
                            <a><button type="submit" name="LOGOUT"
                                        style="border:none;background-color:transparent;">Logout</button></a>
                    </form>
                   
                    
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-center">
                <a href="homepage.php" class="logo">
                    <img src="../assets/images/demos/demo-6/sewcutlogo.png" alt="Molla Logo" width="150" height="20">
                </a>
            </div>
            <div class="header-right">
                <a href="#" class="wishlist-link">
                    <i class="icon-heart-o"></i>
                    <?php $count = countWishlist($_SESSION['id']) ?>
                    <span class="wishlist-count">
                        <?php echo $count ?>
                    </span>
                    <span class="wishlist-txt">My Wishlist</span>
                </a>
                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-shopping-cart"></i>
                        <?php $countCart = countCart($_SESSION['id']) ?>
                        <span class="cart-count">
                            <?php echo $countCart ?>
                        </span>
                        <span class="cart-txt">My Cart</span>
                    </a>
                </div><!-- End .cart-dropdown -->
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="header-left">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="../View/homepage.php" class="sf-with-ul1">Home</a>
                        </li>
                        <li>
                            <a href="../View/products.php" class="sf-with-u1l">Products</a>
                        </li>
                        <li>
                            <a href="../View/ShopCategories.php" class="sf-with-ul1">Categories</a>
                        </li>
                        <li>
                            <a href="../View/shop.php" class="sf-with-u1l">Shop</a>
                        </li>
                        <li>
                            <a href="../View/guide.php" class="sf-with-u1l">Guide</a>
                        </li>
                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>
            </div><!-- End .header-left -->
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->
        <main class="main">
        	<div class="error-content text-center" style="background-image: url(assets/images/backgrounds/error-bg.jpg)">
            	<div class="container">
            		<h1 class="error-title">Suspended</h1>
                    <?php
                   
                    if ($report['suspension_date'] != '0000-00-00 00:00:00') {
                        // Get the current timestamp
                        $currentTime = time();

                        // Convert the suspension date to a timestamp
                        $suspensionTime = strtotime($report['suspension_date']);

                        // Calculate the time difference
                        $timeDifference = $suspensionTime - $currentTime;

                        // Calculate remaining days, hours, minutes, and seconds
                        $remainingDays = floor($timeDifference / (24 * 3600));
                        $remainingHours = floor(($timeDifference % (24 * 3600)) / 3600);
                        $remainingMinutes = floor(($timeDifference % 3600) / 60);
                        $remainingSeconds = $timeDifference % 60;

                        // Display the time left
                        if ($remainingDays > 0) {
                            echo "Time Left: $remainingDays days, $remainingHours hours, $remainingMinutes minutes, $remainingSeconds seconds";
                        } else {
                            echo "Time Left: $remainingHours hours, $remainingMinutes minutes, $remainingSeconds seconds";
                        }
                    }
                    ?>



                                                     
            		<p>You are suspended for breaking our terms and services.</p>
            	</div>
        	</div>
        </main>
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php include("../layouts/jsfile.layout.php"); ?>
</body>
</html>