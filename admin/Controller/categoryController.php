<?php
include('../../Model/db.php');
include('../../Includes/toastr.inc.php');
session_start();

if (isset($_POST['UPDATE'])) {
    $id = $_POST['id'];
    $category = $_POST['category'];

    if($category != ""){
        $row = updateUser(
            'categories',
            array('id', 'category'),
            array($id, $category)
        );
        if ($row){
            echo "<script>
                    alert('Updated Successfully');
                    window.location.href = '../View/categories.php';
                </script>";
        }else{
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/categories.php';
                </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/categories.php';
                    </script>";
    }
}elseif (isset($_POST['ADD'])) {
    $category = $_POST['category'];

    if($category != ""){
        $row = CreateShop('categories',
                    array('category'),
                    array($category));
        if($row){
            echo "<script>
                    alert('Added Successfully');
                    window.location.href = '../View/categories.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/categories.php';
                    </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/categories.php';
                    </script>";
    }
}elseif (isset($_POST['DELETE'])) {
    $id = $_POST['id'];
    $row = deleteUser('categories', 'id', $id);

    if($row){
        echo "<script>
                alert('Deleted Successfully');
                window.location.href = '../View/categories.php';
              </script>";
    } else {
         echo "<script>
                alert('Error');
                window.location.href = '../View/categories.php';
              </script>";
    }
}
