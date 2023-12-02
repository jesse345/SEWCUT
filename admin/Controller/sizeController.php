<?php
include('../../Model/db.php');
include('../../Includes/toastr.inc.php');
session_start();

if (isset($_POST['UPDATE'])) {
    $id = $_POST['id'];
    $size = $_POST['size'];

    if($size != ""){
        $row = updateUser(
            'sizes',
            array('id', 'size'),
            array($id, $size)
        );
        if ($row){
            echo "<script>
                    alert('Updated Successfully');
                    window.location.href = '../View/size.php';
                </script>";
        }else{
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/size.php';
                </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/size.php';
                    </script>";
    }
}elseif (isset($_POST['ADD'])) {
    $size = $_POST['size'];

    if($size != ""){
        $row = CreateShop('sizes',
                    array('size'),
                    array($size));
        if($row){
            echo "<script>
                    alert('Added Successfully');
                    window.location.href = '../View/size.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/size.php';
                    </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/size.php';
                    </script>";
    }
}elseif (isset($_POST['DELETE'])) {
    $id = $_POST['id'];
    $row = deleteUser('sizes', 'id', $id);

    if($row){
        echo "<script>
                alert('Deleted Successfully');
                window.location.href = '../View/size.php';
              </script>";
    } else {
         echo "<script>
                alert('Error');
                window.location.href = '../View/size.php';
              </script>";
    }
}
