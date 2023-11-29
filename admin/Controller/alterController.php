<?php
include('../../Model/db.php');
include('../../Includes/toastr.inc.php');
session_start();

if (isset($_POST['UPDATE'])) {
    $id = $_POST['id'];
    $alter_name = $_POST['alter_name'];

    if($alter_name != ""){
        $row = updateUser(
            'alters',
            array('id', 'alter_name'),
            array($id, $alter_name)
        );
        if ($row){
            echo "<script>
                    alert('Updated Successfully');
                    window.location.href = '../View/alter.php';
                </script>";
        }else{
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/alter.php';
                </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/alter.php';
                    </script>";
    }
}elseif (isset($_POST['ADD'])) {
    $alter_name = $_POST['alter_name'];

    if($alter_name != ""){
        $row = CreateShop('alters',
                    array('alter_name'),
                    array($alter_name));
        if($row){
            echo "<script>
                    alert('Added Successfully');
                    window.location.href = '../View/alter.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Error');
                    window.location.href = '../View/alter.php';
                    </script>";
        }
    }else{
         echo "<script>
                    alert('Input Something');
                    window.location.href = '../View/alter.php';
                    </script>";
    }
}elseif (isset($_POST['DELETE'])) {
    $id = $_POST['id'];
    $row = deleteUser('alters', 'id', $id);

    if($row){
        echo "<script>
                alert('Deleted Successfully');
                window.location.href = '../View/alter.php';
              </script>";
    } else {
         echo "<script>
                alert('Error');
                window.location.href = '../View/alter.php';
              </script>";
    }
}
