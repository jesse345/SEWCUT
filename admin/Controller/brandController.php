<?php
include('../../Model/db.php');
include('../../Includes/toastr.inc.php');
session_start();

if (isset($_POST['UPDATE'])) {
    $id = $_POST['id'];
    $brand = $_POST['brand_name'];

    if($brand != ""){
        $row = updateUser(
            'brands',
            array('id', 'brand_name'),
            array($id, $brand)
        );
        if ($row){
            echo "<script>
                    alert('Updated Successfully');
                    window.location.href = '../View/brand.php';
                </script>";
        }else{
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/brand.php';
                </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/brand.php';
                    </script>";
    }
}elseif (isset($_POST['ADD'])) {
    $brand = $_POST['brand'];

    if($brand != ""){
        $row = CreateShop('brands',
                    array('brand_name'),
                    array($brand));
        if($row){
            echo "<script>
                    alert('Added Successfully');
                    window.location.href = '../View/brand.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/brand.php';
                    </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/brand.php';
                    </script>";
    }
}elseif (isset($_POST['DELETE'])) {
    $id = $_POST['id'];
    $row = deleteUser('brands', 'id', $id);

    if($row){
        echo "<script>
                alert('Deleted Successfully');
                window.location.href = '../View/brand.php';
              </script>";
    } else {
         echo "<script>
                alert('Error');
                window.location.href = '../View/brand.php';
              </script>";
    }
}
