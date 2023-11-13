<?php
include('../../Model/db.php');
session_start();
error_reporting(0);

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$verify = countVerify();
$notVerify = countNotVerify();
$users = countAllUser();
$product_sold = countAllProductSold();
$subscribers = countAllSubscribers();
$total_revenue = countAlllTotalRevenue();
$orders = getOrderlimit5();
$categoryCounts = getCountByCategory();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SEWCUT | DASHBOARD </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico" />
    <link href="../layouts/collapsible-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/collapsible-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/collapsible-menu/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/collapsible-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/collapsible-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/components/list-group.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/dashboard/dash_2.css" rel="stylesheet" type="text/css" />

    <link href="../src/assets/css/dark/components/list-group.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/dark/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>

<body class="alt-menu">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->

    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php include("../Includes/sidebar.includes.php"); ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content" style="margin-top:5px;">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    <div class="row mt-5">
                        <div class="col-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="card-title">Total Users</h5>
                                            <p class="mb-0">
                                                <?php echo $users['users'] ?>
                                            </p>
                                        </div>
                                        <div class="col-4">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-user">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="card-title">Product Sold</h5>
                                            <p class="mb-0">
                                                <?php echo 
                                                $product_sold['product_sold']; ?>
                                            </p>
                                        </div>
                                        <div class="col-4">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-command">
                                                    <path
                                                        d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3H6a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3 3 3 0 0 0-3 3 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 3 3 0 0 0-3-3z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="card-title">Total Revenue</h5>
                                            <p class="mb-0">
                                                <?php echo $total_revenue['total_revenue']; ?>
                                            </p>
                                        </div>
                                        <div class="col-4">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-dollar-sign">
                                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="card-title">Subscribed</h5>
                                            <p class="mb-0">
                                                <?php echo 
                                                $subscribers['subscribers']; ?>
                                            </p>
                                        </div>
                                        <div class="col-4">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-user">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row layout-top-spacing">
                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-chart-two">
                                <div class="widget-heading">
                                    <h5 class="">Sales by Category</h5>
                                </div>
                                <div class="widget-content">
                                    <div id="chart-2" class=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-table-two" style="height: 447px;max-height: 447px;">
                                <div class="widget-heading">
                                    <h5 class="">Recent Orders</h5>
                                </div>
                                <div class="widget-content">
                                    
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="th-content">Customer</div>
                                                    </th>
                                                    <th>
                                                        <div class="th-content">Product</div>
                                                    </th>
                                                    <th>
                                                        <div class="th-content">Quantity</div>
                                                    </th>
                                                    <th>
                                                        <div class="th-content th-heading">Price</div>
                                                    </th>
                                                    <th>
                                                        <div class="th-content">Status</div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($order = mysqli_fetch_assoc($orders)):
                                                $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $order['user_id']));
                                                $product = mysqli_fetch_assoc(getrecord('product_details', 'id', $order['product_id']));
                                                $cart = mysqli_fetch_assoc(getrecord('carts', 'id', $order['cart_id']));
                                                $product_etc = mysqli_fetch_assoc(getrecord('product_details_etc', 'product_id', $order['product_id']));
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="td-content customer-name"><img
                                                                src="../../<?=$user['user_img']?>"
                                                                alt="avatar"><span><?=ucfirst($user['firstname']). ' ' . ucfirst($user['lastname'])?></span></div>
                                                    </td>
                                                    <td>
                                                        <div class="td-content product-brand text-warning"><?=$product['product_name']?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="td-content product-invoice"><?=$cart['quantity']?></div>
                                                    </td>
                                                    <td>
                                                        <div class="td-content pricing"><span class=""><?=$product_etc['price']?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if($order['status'] == 'Approve'){ ?>
                                                        <div class="td-content"><span
                                                                class="badge badge-info"><?=$order['status']?></span></div>
                                                        <?php }else{?>
                                                        <div class="td-content"><span
                                                                class="badge badge-primary"><?=$order['status']?></span></div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  BEGIN FOOTER  -->
            <!--  END CONTENT AREA  -->
        </div>
        <!--  END CONTENT AREA  -->
        
        <?php /*while($countQuery = mysqli_fetch_assoc($categoryCounts)):
            if($countQuery['category'] == 'T-Shirts'){?>
                <input type="hidden" id="TshirtTotalCategory" value="<?=$countQuery['category_count']?>">
            <?php }elseif($countQuery['category'] == 'Bags'){?>
                <input type="hidden" id="BagsTotalCategory" value="<?=$countQuery['category_count']?>">
            <?php }elseif($countQuery['category'] == 'Dresses'){?>
                <input type="hidden" id="DressTotalCategory" value="<?=$countQuery['category_count']?>">
            <?php }elseif($countQuery['category'] == 'Jeans'){?>
                <input type="hidden" id="JeansTotalCategory" value="<?=$countQuery['category_count']?>">
            <?php } ?>
        <?php endwhile; */?> 
    
    </div>
    <!-- END MAIN CONTAINER -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- <script>
        if($("#BagsTotalCategory").val() == 'undenfined'){
            var bag = 0;
        }else{
             var bag = $("#BagsTotalCategory").val();
        }
        var tshirt = $("#TshirtTotalCategory").val();
        var dress = $("#DressTotalCategory").val();
        var jeans = $("#JeansTotalCategory").val();
        
    </script> -->
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/collapsible-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/assets/js/dashboard/dash_2.js"></script>
   
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    

</body>

</html>
