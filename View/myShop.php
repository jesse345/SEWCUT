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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php include("../layouts/head.layout.php") ?>
    <link rel="stylesheet" href="../assets/css/myProduct.css">
    <style>
        .btn {
            min-width: 100px;
        }

        input[type=text] {
            border: 1px solid #000;
            color: #000;
        }
    </style>
</head>

<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    $users = mysqli_fetch_assoc(getrecord('users','id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <div class="container mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Shop</li>
                </ol>
            </nav>
        </div>
        <main class="main mt-3">
            <div class="page-content">
                <div class="dashboard">
                    <div class="container-fluid">
                        <div class="row">
                            <aside class="col-md-2 col-lg-2" style="border-right: 1px solid #ebebeb;">
                                <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist"
                                    style="height:600px;">
                                    <li class="nav-item">
                                        <a href="myAccount.php" class="nav-link">My Account</a>
                                    </li>
                                     <li class="nav-item">
                                        <a href="gcash_info.php" class="nav-link">Gcash Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="myProduct.php" class="nav-link">My Product</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="manageOrder.php" class="nav-link">Orders</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="myPurchase.php" class="nav-link">My Purchase</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="myShop.php" class="nav-link active">My shop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="customAndAlter.php" class="nav-link">Custom & Alter Transaction</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="mySubscription.php" class="nav-link">Manage Subscription</a>
                                    </li>
                                </ul>
                            </aside>
                            <div class="col-10">
                                <?php $user1 = getShop($_SESSION['id']);
                                $shop = mysqli_fetch_assoc($user1);
                                if ($user && mysqli_num_rows($user1) == 0) { 
                                    if($users['isSubscribe'] == 'Yes'){
                                        ?>
                                        <a href="#create_shop" data-toggle="modal" class="btn btn-dark">Create Shop</a>
                                    <?php } else { ?>
                                        <a href="subscription.php"  class="btn btn-dark">Create Shop</a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="page-header text-center"
                                        style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                                        <div class="container">
                                            <h1 class="page-title"
                                                style="color:#000;font-size:5rem!important;font-weight:500;">
                                                <?php echo strtoupper($shop['shop_name']); ?><span style="color:#26180b;">
                                                    <?php echo $shop['address']; ?>
                                                </span>
                                            </h1>
                                        </div>
                                    </div>
                                  
                                    <table class="table table-hover text-center mt-5">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="width:2%">#</th>
                                                <th>TYPE</th>
                                                <th>STATUS</th>
                                                <th>FEEDBACK</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $count = 0 ;
                                        $customize = displayProduct('shop_customoralter');
                                        while($data = mysqli_fetch_assoc($customize)){
                                            $count++;
                                            $shopOwner = mysqli_fetch_assoc(getrecord('shops','id',$data['shop_id']));
                                            $customer = mysqli_fetch_assoc(getrecord('user_details','id',$data['user_id']));
                                            $shopInfo = mysqli_fetch_assoc(getrecord('shop_info','shop_customoralter_id',$data['id']));
                                            $shopHomeService = getrecord('shop_homeservice','shop_customoralter_id',$data['id']);
                                            $shopMeasurement = mysqli_fetch_assoc(getrecord('shop_measurerments','shop_customoralter_id',$data['id']));
                                            $dataImage = getrecord('shop_images','shop_customoralter_id',$data['id']);
                                            if($shopOwner['user_id'] == $_SESSION['id']){
                                                ?>
                                                <tr>
                                                    <td><?=$count?></td>
                                                    <td><button class="btn btn-warning mr-2"><?=$data['type']?></button></td>
                                                    <td><button class="btn btn-warning"><?=$data['status']?></button></td>
                                                    <td><button class="btn btn-warning">View Feedback</button></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="#viewmore-Modal<?php echo $data['id'] ?>" data-toggle="modal" class="btn btn-info mx-2">View Details</a>
                                                            <a href="chat.php?user=<?=$data['user_id']?>" class="btn btn-info mx-2">Chat Customer</a>
                                                             <?php if($data['status'] == 'Approved') {?>
                                                             <button class="btn btn-info mx-2">Add Feedback</button>
                                                             <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="viewmore-Modal<?php echo $data['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog custom-modal" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <p>View More</p>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"><i class="icon-close"></i></span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label>INFO</label> 
                                                                <div class="form-group mt-2">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" value="<?=$shopInfo['name'] ?>"  readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Phone Number</label>
                                                                    <input type="text" class="form-control" value="<?=$shopInfo['phone'] ?>"  readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="text" class="form-control" value="<?=$shopInfo['email'] ?>"  readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Category</label>
                                                                    <input type="text" class="form-control" value="<?=$shopInfo['category'] ?>"  readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Instruction</label>
                                                                    <input type="text" class="form-control" value="<?=$shopInfo['instruction'] ?>"  readonly>
                                                                </div>
                                                                 <div class="form-group mb-2">
                                                                    <label>Image Design</label>
                                                                    <div class="preview-item">
                                                                        <div class="row">
                                                                            <?php while($images = mysqli_fetch_assoc( $dataImage)){?>
                                                                                <div class="col-3">
                                                                                    <img src="<?php echo $images['images']; ?>">
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <?php if(mysqli_num_rows($shopHomeService) > 0 ){
                                                                    $homeservice = mysqli_fetch_assoc($shopHomeService);
                                                                    ?>
                                                                    
                                                                    <label>Home Service Info</label> 
                                                                    <div class="row mt-2">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label>Address</label>
                                                                                <input type="text" class="form-control" value="<?=$homeservice['address'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label>Schedule</label>
                                                                                <input type="text" class="form-control" value="<?=$homeservice['schedule'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                <?php }else{?>
                                                                    <label>MEASUREMENTS</label> 
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Neck</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['neck'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Shoulder</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['shoulder'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Sleeve</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['sleeve'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Chest</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['chest'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Waist</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['waist'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Hips</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['hips'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Inseam</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['inseam'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Thigh</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['thigh'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Height</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['height'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                         <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Bodice</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['bodice'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Bust</label>
                                                                                <input type="text" class="form-control" value="<?=$shopMeasurement['bust'] ?>"  readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <?php if($data['status'] == 'Pending') {?>
                                                                    <form action="../Controller/shopController.php" method="POST">
                                                                        <input type="hidden" name="id" value="<?=$data['id']?>">
                                                                        <button type="submit" class="btn btn-info mx-2" name="BTN_APPROVE">Approve</button>
                                                                    </form>
                                                                    <form action="../Controller/shopController.php" method="POST">
                                                                        <input type="hidden" name="id" value="<?=$data['id']?>">
                                                                    <button class="btn btn-danger mx-2" name="BTN_DISAPPROVE">Disapprove</button>
                                                                    </form>
                                                                <?php }elseif($data['status'] == 'Approved'){  ?>
                                                                    <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                                        Close
                                                                    </button>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                            
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <div class="modal fade" id="create_shop" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Create Shop</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <form action="../Controller/shopController.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" class="form-control" name="shop_name" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <select name="address" class="form-control" require>
                                <option value="" disable>Select Address</option>
                                <?php $add = getallrecord('address');
                                while ($address = mysqli_fetch_assoc($add)): ?>
                                    <option value="<?php echo $address['id'] ?>">
                                        <?php echo $address['address'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <label for="">Shop Can:</label>
                        <div class="form-group mb-0">
                            <input type="checkbox" id="customize" name="can_customize"> Customize
                        </div>
                            <div class="form-group" id="show_customize" style="margin-left:40px;">
                                <label style="margin-bottom:0;">Shop Can Customize:</label>
                               <?php $categories = getallrecord('categories');
                                while ($category = mysqli_fetch_assoc($categories)) {
                                    ?>
                                    <div class="form-group mb-0">
                                        <input type="checkbox" name="can_customize[]" value="<?=$category['category']?>"> <?=$category['category']?>
                                    </div>
                                <?php } ?>
                                
                            </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_alter"> Alter
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="homeservice"> Do Home Service
                        </div>
                    
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                        <button type="submit" class="btn btn-dark products" id="add_product_btn"
                            name="CREATESHOP">CREATE SHOP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php 
        include("../layouts/jsfile.layout.php");
        include("toastr.php");
        include('../assets/js/prod.php');
    ?>
    
</body>
<script>
    $(document).ready(function () {
        $("#show_customize").hide()
        $("#customize").change(function () {
            if ($(this).is(":checked")) {
                $("#show_customize").show();
            } else {
                $("#show_customize").hide();
            }
        });
    });
   
    
</script>
</html>
