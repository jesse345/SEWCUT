<?php
include('../../Model/db.php');
include('../../Includes/toastr.inc.php');
session_start();

if (isset($_POST['UPDATE'])) {
    $id = $_POST['id'];
    $garment_name = $_POST['garment_name'];

    if($garment_name != ""){
        $row = updateUser(
            'garments',
            array('id', 'garment_name'),
            array($id, $garment_name)
        );
        if ($row){
            echo "<script>
                    alert('Updated Successfully');
                    window.location.href = '../View/garment.php';
                </script>";
        }else{
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/garment.php';
                </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/garment.php';
                    </script>";
    }
}elseif (isset($_POST['ADD'])) {
    $garment_name = $_POST['garment_name'];

    if($garment_name != ""){
        $row = CreateShop('garments',
                    array('garment_name'),
                    array($garment_name));
        if($row){
            echo "<script>
                    alert('Added Successfully');
                    window.location.href = '../View/garment.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/garment.php';
                    </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/garment.php';
                    </script>";
    }
}elseif (isset($_POST['DELETE'])) {
    $id = $_POST['id'];
    $row = deleteUser('garments', 'id', $id);

    if($row){
        echo "<script>
                alert('Deleted Successfully');
                window.location.href = '../View/garment.php';
              </script>";
    } else {
         echo "<script>
                alert('Error');
                window.location.href = '../View/garment.php';
              </script>";
    }
}
