<?php
include('../../Model/db.php');
include('../../Includes/toastr.inc.php');
session_start();

if (isset($_POST['UPDATE'])) {
    $id = $_POST['id'];
    $color_name = $_POST['color_name'];

    if($color_name != ""){
        $row = updateUser(
            'colors',
            array('id', 'color_name'),
            array($id, $color_name)
        );
        if ($row){
            echo "<script>
                    alert('Updated Successfully');
                    window.location.href = '../View/color.php';
                </script>";
        }else{
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/color.php';
                </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/color.php';
                    </script>";
    }
}elseif (isset($_POST['ADD'])) {
    $color_name = $_POST['color_name'];

    if($color_name != ""){
        $row = CreateShop('colors',
                    array('color_name'),
                    array($color_name));
        if($row){
            echo "<script>
                    alert('Added Successfully');
                    window.location.href = '../View/color.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/color.php';
                    </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/color.php';
                    </script>";
    }
}elseif (isset($_POST['DELETE'])) {
    $id = $_POST['id'];
    $row = deleteUser('colors', 'id', $id);

    if($row){
        echo "<script>
                alert('Deleted Successfully');
                window.location.href = '../View/color.php';
              </script>";
    } else {
         echo "<script>
                alert('Error');
                window.location.href = '../View/color.php';
              </script>";
    }
}
