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
                                        <a href="mySubscription.php" class="nav-link">Manage Subscription</a>
                                    </li>
                                </ul>
                            </aside>
                            <div class="col-10">
                                <?php $user1 = getShop($_SESSION['id']);
                                $shop = mysqli_fetch_assoc($user1);
                                if ($user && mysqli_num_rows($user1) == 0) { ?>
                                    <a href="#create_shop" data-toggle="modal" class="btn btn-dark">Create Shop</a>
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
                                    <?php 
                                    if($user['gcash_name'] == '' || $user['gcash_number'] == ''){?>
                                        <form action="../Controller/shopController.php" method="POST">
                                            <button name="BINDGCASH" class="btn btn-dark float-right" style="margin-top: 5px;">Add Product</button>
                                        </form>
                                    <?php } else{ ?>
                                        <a id="btn_addProduct" class="btn btn-dark float-right text-white" style="margin-top: 5px;">Add Product</a>
                                    <?php } ?>
                                     <table class="table table-hover text-center mt-5">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        $productData = displayProductInShop('products', 'user_id', $_SESSION['id'],'Yes');
                                            if(mysqli_num_rows($productData) > 0){
                                                while($product = mysqli_fetch_assoc($productData)):
                                                $productDetails = mysqli_fetch_assoc(displayDetails('product_details', 'id', $product['id']));
                                                $productImages = displayDetails('product_images', 'product_id', $product['id']);
                                                $product_details_etc = displayDetails('product_details_etc', 'product_id', $product['id']);
                                                $count++;
                                                ?>
                                                <tr> 
                                                    <td><b><?php echo $count ?></b></td>
                                                    <td><?php echo $productDetails['product_name'] ?></td>
                                                    <td>
                                                        <?php 
                                                        $stock = 0; // Initialize the $stock variable to 0 before the loop
                                                        while($pq = mysqli_fetch_assoc($product_details_etc)): 
                                                            $stock += $pq['quantity']; // Use += to accumulate the quantities
                                                        endwhile; 
                                                        echo $stock;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if($stock > 0){ ?>
                                                            <button  class="btn btn-success products">In Stock</button>
                                                        <?php } else { ?>
                                                            <button class="btn btn-danger products">Out of Stock</button>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <a href="#viewmore-Modal<?php echo $product['id'] ?>" data-toggle="modal" class="btn btn-info products">View More</a>
                                                        <a href="#update-Modal<?php echo $product['id'] ?>" data-toggle="modal" class="btn btn-success products">Update</a>
                                                        <a href="#delete-Modal<?php echo $product['id'] ?>" data-toggle="modal" class="btn btn-danger products">Delete</a>
                                                    </td>
                                                </tr>
                                                 <!-- VIEW MORE MODAL -->
                                                <div class="modal fade" id="viewmore-Modal<?php echo $product['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog custom-modal add-modal" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <p>View More Details</p>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"><i class="icon-close"></i></span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Product Name</label>
                                                                    <input type="text" class="form-control" value="<?php echo $productDetails['product_name'] ?>"  readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="comment">Descriptions</label>
                                                                    <textarea class="form-control" rows="5" readonly><?php echo $productDetails['description'] ?></textarea>
                                                                </div>
                                                                <?php  
                                                                mysqli_data_seek($product_details_etc, 0);
                                                                while($pqe = mysqli_fetch_assoc($product_details_etc)): 
                                                                ?>
                                                                    <div class="row">
                                                                        <div class="col-sm-3 col-lg-3">
                                                                            <label>Color</label>
                                                                            <input type="text" class="form-control" value="<?php echo $pqe['color']?>" readonly>
                                                                        </div>
                                                                        <div class="col-sm-3 col-lg-3">
                                                                            <label>Size</label>
                                                                            <input type="text" class="form-control" value="<?php echo $pqe['size']?>" readonly>
                                                                        </div>
                                                                        <div class="col-sm-3 col-lg-2">
                                                                            <label>Price</label>
                                                                            <input type="text" class="form-control" value="<?php echo $pqe['price']?>" readonly>
                                                                        </div>
                                                                        <div class="col-sm-3 col-lg-2">
                                                                            <label>Stock</label>
                                                                            <input type="text" class="form-control" value="<?php echo $pqe['quantity']?>" readonly>
                                                                        </div>
                                                                    </div>
                                                                <?php endwhile; ?>
                                                                <div class="form-group">
                                                                    <label>Category</label>
                                                                    <input type="text" class="form-control" value="<?php echo $productDetails['category'] ?>"  readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Product Brand</label>
                                                                    <input type="text" class="form-control" value="<?php echo $productDetails['brand'] ?>"  readonly>
                                                                </div>
                                                                <div class="card-body">
                                                                    <label>Images</label>
                                                                    <div style="display:flex">
                                                                        <?php while ($pi = mysqli_fetch_assoc($productImages)): ?>
                                                                            <?php
                                                                            $imagePath = $pi['image'];
                                                                            $fileExtension = pathinfo($imagePath, PATHINFO_EXTENSION);

                                                                            if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])):
                                                                                // Display images
                                                                            ?>
                                                                            <div class="preview-item">
                                                                                <img src="<?php echo $imagePath; ?>">
                                                                            </div>
                                                                            <?php endif; ?>
                                                                        <?php endwhile; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <label>Videos</label>
                                                                    <div style="display:block">
                                                                        <?php mysqli_data_seek($productImages, 0); // Reset the pointer to the beginning of the result set ?>
                                                                        <?php while ($pi = mysqli_fetch_assoc($productImages)): ?>
                                                                            <?php
                                                                            $imagePath = $pi['image'];
                                                                            $fileExtension = pathinfo($imagePath, PATHINFO_EXTENSION);

                                                                            if (strtolower($fileExtension) == 'mp4'):
                                                                                // Display videos
                                                                            ?>
                                                                            <div class="preview-item1">
                                                                                <video width="100%" height="100%" controls>
                                                                                    <source src="<?php echo $imagePath; ?>" type="video/mp4">
                                                                                </video>
                                                                            </div>
                                                                            <?php endif; ?>
                                                                        <?php endwhile; ?>
                                                                    </div>
                                                                </div>

                                                                 <div class="form-group">
                                                                    <label for="comment">Additional Info</label>
                                                                    <textarea class="form-control" rows="5" readonly><?php echo $productDetails['additional_info'] ?></textarea>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                                    Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <!-- DELETE MODAL -->
                                                <div class="modal fade" id="delete-Modal<?php echo $product['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header header1">
                                                                
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"><i class="icon-close"></i></span>
                                                                </button>
                                                            </div>
                                                            <form action="../Controller/ProductController.php" method="POST">
                                                                <div class="modal-body">
                                                                    <p style="font-size: 15px; font-weight: 500;">Are you sure you want to delete this product ?</p>
                                                                </div>
                                                                <input type="hidden" name="id" value="<?php echo $product['id']?>">
                                                                <div class="modal-footer footer1">
                                                                    <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                                        No
                                                                    </button>
                                                                    <button type="submit" class="btn btn-dark products" name="DELETEPRODUCT">Yes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <!-- UPDATE MODAL -->
                                                <div class="modal fade" id="update-Modal<?php echo $product['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog custom-modal update-modal" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <p>Update Product</p>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"><i class="icon-close"></i></span>
                                                                </button>
                                                            </div>
                                                            <form action="../Controller/ProductController.php" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-body">                    
                                                                    <div class="form-group">
                                                                        <label>Product Name</label>
                                                                        <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                                                                        <input type="text" class="form-control" name="product_name" value="<?php echo $productDetails['product_name'] ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="comment">Descriptions</label>
                                                                        <textarea class="form-control" name="description" rows="5" ><?php echo $productDetails['description'] ?></textarea>
                                                                    </div>
                                                                    <?php  
                                                                    $color = sizeOrColor('colors'); 
                                                                    $size  = sizeOrColor('sizes'); 
                                                                    $category = sizeOrColor('categories');
                                                                    
                                                                    mysqli_data_seek($product_details_etc, 0);
                                                                    while($pqe = mysqli_fetch_assoc($product_details_etc)): 
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-sm-3 col-lg-3">
                                                                                <label>Color</label>
                                                                                <input type="hidden" name="pqe_id[]" value="<?php echo $pqe['id']?>">
                                                                                <select class="form-control" name="color[]">
                                                                                    <option value="<?php echo $pqe['color']?>" selected><?php echo $pqe['color']?></option>
                                                                                    <?php 
                                                                                    mysqli_data_seek($color, 0);
                                                                                    while($c = mysqli_fetch_assoc($color)):
                                                                                        if ($c['color_name'] != $pqe['color']){
                                                                                        ?>
                                                                                        <option value="<?php echo $c['color_name']?>"><?php echo $c['color_name']?></option>
                                                                                        <?php } ?>
                                                                                        
                                                                                    <?php endwhile; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-3 col-lg-3">
                                                                                <label>Size</label>
                                                                                <select class="form-control" name="size[]">
                                                                                    <option value="<?php echo $pqe['size']?>" selected><?php echo $pqe['size']?></option>
                                                                                    <?php 
                                                                                    mysqli_data_seek($size, 0);
                                                                                    while($s = mysqli_fetch_assoc($size)):
                                                                                        if ($s['size'] != $pqe['size']){
                                                                                            ?>
                                                                                            <option value="<?php echo $s['size']?>"><?php echo $s['size']?></option>
                                                                                        <?php } ?>
                                                                                    <?php endwhile; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-3 col-lg-2">
                                                                                <label>Price</label>
                                                                                <input type="text" class="form-control" name="price[]" value="<?php echo $pqe['price']?>" >
                                                                            </div>
                                                                            <div class="col-sm-3 col-lg-2">
                                                                                <label>Stock</label>
                                                                                <input type="text" class="form-control" name="stock[]" value="<?php echo $pqe['quantity']?>">
                                                                            </div>
                                                                        </div>
                                                                    <?php endwhile; ?>
                                                                    <label for="">Category<span style="color:red">*</span></label>
                                                                    <select class="form-control" name="category" require>
                                                                        <option value="<?php echo $productDetails['category'];?>" selected><?php echo $productDetails['category'];?></option>
                                                                        <?php
                                                                        mysqli_data_seek($category, 0);
                                                                        while($c = mysqli_fetch_assoc($category)):?>
                                                                            <?php if ($c['category'] != $productDetails['category']) {?>
                                                                                <option value="<?php echo $c['category']?>"><?php echo $c['category']?></option>
                                                                            <?php } ?>
                                                                        <?php endwhile; ?>
                                                                    </select>
                                                                    <div class="form-group">
                                                                        <label>Product Brand</label>
                                                                        <input type="text" class="form-control" name="brand" value="<?php echo $productDetails['brand'] ?>" >
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <label>Images</label>
                                                                        <div style="display:flex">
                                                                            <?php mysqli_data_seek($productImages, 0); // Reset the pointer to the beginning of the result set
                                                                            $count = 0 ; ?>
                                                                            <?php while ($pi = mysqli_fetch_assoc($productImages)): ?>
                                                                                <?php
                                                                                $imagePath = $pi['image'];
                                                                                $fileExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                                                $count++;
                                                                                if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])):
                                                                                    // Display images
                                                                                ?>
                                                                                <div class="form-element">
                                                                                    <input type="hidden" name="image_id[]" value="<?=$pi['id']?>">
                                                                                    <input type="file" id="file-<?php echo $count?>" name="image[]" accept="image/*"
                                                                                        >
                                                                                    <label for="file-<?php echo $count?>" id="file-<?php echo $count?>-preview">
                                                                                        <img src="<?php echo $imagePath; ?>"
                                                                                            class="img-responsive">
                                                                                        <div>
                                                                                            <span>+</span>
                                                                                        </div>
                                                                                    </label>
                                                                                </div>
                                                                                <?php endif; ?>
                                                                            <?php endwhile; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <label>Videos</label>
                                                                        <div style="display:block">
                                                                            <?php mysqli_data_seek($productImages, 0); // Reset the pointer to the beginning of the result set ?>
                                                                            <?php 
                                                                            $videocount = 20 ;
                                                                            while ($pi = mysqli_fetch_assoc($productImages)): ?>
                                                                                <?php
                                                                               
                                                                                $imagePath = $pi['image'];
                                                                                $fileExtension = pathinfo($imagePath, PATHINFO_EXTENSION);

                                                                                if (strtolower($fileExtension) == 'mp4'):
                                                                                    // Display videos
                                                                                    $videocount++;
                                                                                ?>
                                                                                <video width="100%" height="100%" controls>
                                                                                    <source src="<?php echo $imagePath; ?>" type="video/mp4">
                                                                                </video>
                                                                                        
                                                                                
                                                                                <?php endif; ?>
                                                                            <?php endwhile; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="comment">Additonal Info</label>
                                                                        <textarea class="form-control" name="add_info" rows="5" ><?php echo $productDetails['additional_info'] ?></textarea>
                                                                    </div>
                                                                   
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger products" data-dismiss="modal" aria-label="Close">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-dark products" id="UPDATE" name="UPDATEPRODUCT">UPDATE</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endwhile; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="6">No product</td>
                                                </tr>
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
                        <div class="form-group">
                            <input type="checkbox" name="can_alter"> Alter
                        </div>
                    
                        <div class="form-group" id="show_customize">
                        <label for="">Shop Can Customize:</label>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Dresses"> Dresses
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="T-Shirts"> T-Shirts
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Jeans"> Jeans
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Jackets"> Jackets
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Bag"> Bag
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Sportswears"> Sportswears
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Shoes"> Shoes
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="can_customize[]" value="Jumpers"> Jumpers
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
