<?php
error_reporting(0);
$report = mysqli_fetch_assoc(reports($_SESSION['id']));
$currentDateTime = time();

if(strtotime($report['suspension_date']) > $currentDateTime)
    header("location:../View/suspend.php");
?>
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
                <?php if (isset($_SESSION['id'])) { ?>
                    <?php
                    $unread = mysqli_num_rows(unRead($_SESSION['id'])) ?>
                    <a href="../View/notification.php" class="mr-4">
                        Notifications
                        <?php echo $unread > 0 ? "($unread)" : '' ?>
                    </a>
                <?php } ?>
                <a href="../View/chat.php" class="mr-4">Chat</a>
                <div class="header-dropdown">
                    <a href="#"><i class="icon-user"> </i>
                        <?php echo ucfirst($user['firstname']) . " " . ucfirst($user['lastname']) ?>
                    </a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="myAccount.php">My Account</a></li>
                            <li><a href="myProduct.php">My Products</a></li>
                            <li><a href="manageOrder.php">Orders</a></li>
                            <li><a href="myPurchase.php">My Purchase</a></li>
                            <li><a href="myShop.php">My Shop</a></li>
                            <li><a href="mySubscription.php">My Subscription</a></li>
                            <li><a href="transactionReport.php">Transaction Report</a></li>
                            <form action="../Controller/userController.php" method="POST">
                                <li><a><button type="submit" name="LOGOUT"
                                            style="border:none;background-color:transparent;">Logout</button></a></li>
                            </form>

                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropdown -->
            </div><!-- End .header-right -->
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-center">
                <a href="homepage.php" class="logo">
                    <img src="../assets/images/demos/demo-6/sewcutlogo.png" alt="Molla Logo" width="150" height="20">
                </a>
            </div><!-- End .header-left -->


            <div class="header-right">
                <a href="../View/wishlist.php" class="wishlist-link">
                    <i class="icon-heart-o"></i>
                    <?php $count = countWishlist($_SESSION['id']) ?>
                    <span class="wishlist-count">
                        <?php echo $count ?>
                    </span>
                    <span class="wishlist-txt">My Wishlist</span>
                </a>

                <div class="dropdown cart-dropdown">
                    <a href="../View/cart.php" class="dropdown-toggle">
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
