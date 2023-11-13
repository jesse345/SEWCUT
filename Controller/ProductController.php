<?php
session_start();
include '../Model/db.php';
include '../includes/toastr.inc.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!empty($_SESSION['id'])) {
    if (isset($_POST['ADDPRODUCT'])) {
        $category = $_POST['category'];
        $product_name = $_POST['product_name'];
        $description = $_POST['description'];
        $add_info = $_POST['add_info'];
        $brand = $_POST['brand'];

        $color = $_POST['color'];
        $size = $_POST['size'];
        $price = $_POST['price'];
        $quantity = $_POST['stock'];

      
        $product_fields = array('id', 'category', 'product_name', 'description', 'additional_info', 'brand');
        $product_values = array($category, $product_name, $description, $add_info, $brand);

        addProduct(
            'products',
            array('user_id'),
            array($_SESSION['id']),
            'product_details',
            $product_fields,
            $product_values
        );

        // Get the product ID that was just inserted
        $product_id = mysqli_insert_id($conn);

        // Loop through color, size, price, and quantity arrays and insert into product_details_etc
        foreach ($color as $i => $c) {
            insertProduct(
                'product_details_etc',
                array('product_id', 'color', 'size', 'price', 'quantity'),
                array($product_id, $c, $size[$i], $price[$i], $quantity[$i])
            );
        }
      
        $targetDir = "../images/";
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];

        foreach ($_FILES['image']['name'] as $key => $name) {
            $fileType = pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
            $targetPath = $targetDir . basename($name);

            if (in_array($fileType, $allowedTypes)) {
                move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetPath);
                insertProduct(
                    'product_images',
                    array('product_id', 'image'),
                    array($product_id, $targetPath)
                );
            } else {
                echo "Invalid file type: $name<br>";
            }
        }
        
        $id = $_SESSION['id'];
        $gName = $_POST['gcash_name'];
        $gNumber = $_POST['gcash_number'];
        
        updateUser(
                'user_details',
                array('id', 'gcash_name','gcash_number'),
                array($id, $gName,$gNumber)
            );

        flash("msg", "success", "Successfully Added");
        header("Location: ../View/myProduct.php");
        exit();

    } elseif (isset($_POST['DELETEPRODUCT'])) {
        $id = $_POST['id'];
        $deleteOrder = mysqli_fetch_assoc(getrecord('orders', 'product_id', $id));

        if ($deleteOrder['status'] != 'Approved') {
            deleteProduct($id);
            flash("msg", "success", "Success");
            header("Location: ../View/myProduct.php");
            exit();

        } else {
            updateProduct(
                'product_quantity',
                array('product_id', 'quantity'),
                array($id, 0)
            );
            flash("msg", "success", "Stock at 0");
            header("Location: ../View/myProduct.php");
            exit();
        }

    } elseif (isset($_POST['UPDATEPRODUCT'])) {
        $product_id = $_POST['product_id'];
        $order = mysqli_fetch_assoc(getrecord('orders', 'product_id', $product_id));

        if ($order['status'] != 'Approved') {
            $category = $_POST['category'];
            $product_name = $_POST['product_name'];
            $description = $_POST['description'];
            $add_info = $_POST['add_info'];

            $color = $_POST['color'];
            $size = $_POST['size'];
            $price = $_POST['price'];
            $quantity = $_POST['stock'];
            $brand = $_POST['brand'];


            $pde_id = $_POST['pqe_id'];

            $product_fields = array('id', 'category', 'product_name', 'description', 'additional_info', 'brand');
            $product_values = array($product_id, $category, $product_name, $description, $add_info, $brand);

            updateProduct(
                'product_details',
                $product_fields,
                $product_values
            );

            foreach ($color as $i => $c) {
                updateProduct(
                    'product_details_etc',
                    array('id', 'color', 'size', 'price', 'quantity'),
                    array($pde_id[$i], $c, $size[$i], $price[$i], $quantity[$i])
                );
            }
            $targetDir = "../images/";
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];
            $img_id = $_POST['image_id'];

            foreach ($_FILES['image']['name'] as $key => $name) {
                $fileType = pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
                $targetPath = $targetDir . basename($name);

                if (in_array($fileType, $allowedTypes)) {
                    move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetPath);
                    updateProduct(
                        'product_images',
                        array('id', 'image'),
                        array($img_id[$key], $targetPath)
                    );
                } else {
                    echo "Invalid file type: $name<br>";
                }
            }
            flash("msg", "success", "Successfully Updated");
            header("Location: ../View/myProduct.php");
            exit();
        } else {
            flash("msg", "success", "Cant update anymore");
            header("Location: ../View/myProduct.php");
            exit();
        }
    } elseif (isset($_POST['ADDPRODUCTINSHOP'])) {
        $category = $_POST['category'];
        $product_name = $_POST['product_name'];
        $description = $_POST['description'];
        $add_info = $_POST['add_info'];
        $brand = $_POST['brand'];

        $color = $_POST['color'];
        $size = $_POST['size'];
        $price = $_POST['price'];
        $quantity = $_POST['stock'];

        $product_fields = array('id', 'category', 'product_name', 'description', 'additional_info', 'brand');
        $product_values = array($category, $product_name, $description, $add_info, $brand);

        addProduct(
            'products',
            array('user_id', 'inShop'),
            array($_SESSION['id'], 'Yes'),
            'product_details',
            $product_fields,
            $product_values
        );

        // Get the product ID that was just inserted
        $product_id = mysqli_insert_id($conn);

        // Loop through color, size, price, and quantity arrays and insert into product_details_etc
        foreach ($color as $i => $c) {
            insertProduct(
                'product_details_etc',
                array('product_id', 'color', 'size', 'price', 'quantity'),
                array($product_id, $c, $size[$i], $price[$i], $quantity[$i])
            );
        }
        $targetDir = "../images/";
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];

        foreach ($_FILES['image']['name'] as $key => $name) {
            $fileType = pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
            $targetPath = $targetDir . basename($name);

            if (in_array($fileType, $allowedTypes)) {
                move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetPath);
                insertProduct(
                    'product_images',
                    array('product_id', 'image'),
                    array($product_id, $targetPath)
                );
            } else {
                echo "Invalid file type: $name<br>";
            }
        }

        flash("msg", "success", "Successfully Added");
        header("Location: ../View/myShop.php");
        exit();
    }
} else {
    echo "<script>
            alert('Login First');
            window.location.href='../index.php';
        </script>";
}
