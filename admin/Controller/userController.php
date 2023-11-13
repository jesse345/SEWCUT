<?php
include('../../Model/db.php');
include('../../Includes/toastr.inc.php');
session_start();


if (isset($_POST['UPDATE'])) {
    //global
    $user_id = $_POST['user_id'];
    // users
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    updateUser(
        'users',
        array('id', 'username', 'email', 'email'),
        array($user_id, $username, $email, $password)
    );
    // user_details
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    updateUser(
        'user_details',
        array('id', 'firstname', 'lastname', 'address', 'contact_number'),
        array($user_id, $firstname, $lastname, $address, $contact)
    );
    echo "<script>
                alert('Updated Successfully');
                window.location.href = '../View/user.php';
              </script>";

} elseif (isset($_POST['DELETE'])) {
    //global
    $user_id = $_POST['user_id'];

    // users
    deleteUser('users', 'id', $user_id);

    // user_details
    deleteUser('user_details', 'id', $user_id);
    echo "<script>
                alert('Deleted Successfully');
                window.location.href = '../View/user.php';
              </script>";
} elseif (isset($_POST['PAYMENT'])) {
    $user_id = $_SESSION['admin_id'];
    $gcash_name = $_POST['gcash_name'];
    $gcash_number = $_POST['gcash_number'];

    updateUser(
        'admin',
        array('id', 'gcash_name', 'gcash_number'),
        array($user_id, $gcash_name, $gcash_number)
    );
    echo "<script>
                alert('Updated Successfully');
                window.location.href = '../View/managePayment.php';
              </script>";
}
