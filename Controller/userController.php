<?php
include("../Model/db.php");
session_start();
include '../includes/toastr.inc.php';

include("sendEmailController.php");

if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $contact = $_POST['contact_number'];
    $email = $_POST['email'];
    $isLoggedIN = "Yes";
    $address = $_POST['address'];
    $repassword = $_POST['repassword'];
    $checkUsername = getrecord('users', 'username', $username);
    $checkEmail = getrecord('users', 'email', $email);

    if (mysqli_num_rows($checkUsername) > 0) {
        flash("msg", "info", "Username already used");
        header("Location: ../View/register.php");
        exit();

    } elseif (mysqli_num_rows($checkEmail) > 0) {
        flash("msg", "info", "Email already used");
        header("Location: ../View/register.php");
        exit();

    } elseif ($password != $repassword) {
        flash("msg", "info", "Password not match");
        header("Location: ../View/register.php");
        exit();
    } else {

        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        $userfield = array('username', 'email', 'password', 'isLoggedIn');
        $uservalue = array($username, $email, $password, $isLoggedIN);
        $userdetailsfield = array('id', 'firstname', 'lastname', 'address', 'contact_number');
        $userdetailsvalues = array($firstname, $lastname, $address, $contact);

        addUser('users', $userfield, $uservalue, 'user_details', $userdetailsfield, $userdetailsvalues);
        $userid = mysqli_insert_id($conn);
        $_SESSION['id'] = $userid;
        $id = $_SESSION['id'];
        $name = $firstname . ' ' . $lastname;

        createUser(
            'shipping_info',
            array('user_id', 'name', 'contact', 'address'),
            array($id, $name, $contact, $address)
        );

        createUser(
            'verification_codes',
            array('user_id', 'email_address', 'code'),
            array($id, $email, $verification_code)
        );

        $header = header("Location: ../View/verify.php?email=" . $email);
        sendEmail($username, $email, $verification_code, $header);

    }
} elseif (isset($_POST['LOGIN'])) {
    $username = $_POST['singin-username'];
    $password = $_POST['singin-password'];

    $result = login($username, $password);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        flash("msg", "success", "Login Successfully");
        header("Location: ../View/index.php");
        exit();
    } else {
        flash("msg", "error", "Invalid Credentials");
        header("Location: ../View/login.php");
        exit();
    }
} elseif (isset($_POST['UPDATEPROFILE'])) {
    $targetDir = "../images/";
    $target_file = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);

    if ($check !== false) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        updateUser(
            'user_details',
            array('id', 'user_img'),
            array($_SESSION['id'], $target_file)
        );
        flash("msg", "success", "Updated Successfully");
        header("Location: ../View/myAccount.php");
        exit();
    } else {
        flash("msg", "error", "File is not an image.");
        header("Location: ../View/myAccount.php");
        exit();
    }
} elseif (isset($_POST['UPDATEUSER'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $id = $_SESSION['id'];

    $checkUsername = checkUser('username', $username, $id);
    $checkEmail = checkUser('email', $email, $id);

    if (mysqli_num_rows($checkUsername) > 0) {
        flash("msg", "info", "Username already used");
        header("Location: ../View/myAccount.php");
        exit();

    } elseif (mysqli_num_rows($checkEmail) > 0) {
        flash("msg", "info", "Email already used");
        header("Location: ../View/myAccount.php");
        exit();
    } else {

        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        createUser(
            'verification_codes',
            array('user_id', 'email_address', 'code'),
            array($id, $email, $verification_code)
        );
        $header = header("Location: ../View/updateuserverify.php?email=" . $email .
            "&firstname=" . $firstname .
            "&lastname=" . $lastname .
            "&contact=" . $contact .
            "&address=" . $address .
            "&username=" . $username);
        sendEmail($username, $email, $verification_code, $header);
    }


} elseif (isset($_POST['CHANGEPASS'])) {
    $user = mysqli_fetch_assoc(getrecord('users', 'id', $_SESSION['id']));
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($user['password'] == $current_password) {
        if ($new_password == $confirm_password) {
            updateUser(
                'users',
                array('id', 'password'),
                array($_SESSION['id'], $new_password)
            );
            flash("msg", "success", "Successfully Changepassword");
            header("Location: ../View/myAccount.php");
            exit();

        } else {
            flash("msg", "error", "Passwords don't match");
            header("Location: ../View/myAccount.php");
            exit();

        }
    } else {
        flash("msg", "error", "Incorrect Current Password");
        header("Location: ../View/myAccount.php");
        exit();
    }
} elseif (isset($_POST['RESENDCODE'])) {
    $user = mysqli_fetch_assoc(getrecord('users', 'id', $_SESSION['id']));
    $username = $user['username'];
    $email = $user['email'];
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    createUser(
        'verification_codes',
        array('user_id', 'email_address', 'code'),
        array($_SESSION['id'], $email, $verification_code)
    );

    flash("msg", "success", "Successfully sent");
    $header = header("Location: ../View/verify.php?email=" . $email);

    sendEmail($username, $email, $verification_code, $header);

} elseif (isset($_POST['VERIFY'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $id = $_SESSION['id'];
    $timestamp = date("Y-m-d H:i:s");
    $codes = mysqli_fetch_assoc(checkCode($_SESSION['id']));
    $code = $_POST['code'];

    if ($codes['code'] == $code) {
        updateUser(
            'user_details',
            array('id', 'firstname', 'lastname', 'address', 'contact_number'),
            array($id, $firstname, $lastname, $address, $contact)
        );

        updateUser(
            'users',
            array('id', 'username', 'email'),
            array($id, $username, $email)
        );

        flash("msg", "success", "Updated Successfully");
        header("Location: ../View/myAccount.php");
        exit();
    } else {
        flash("msg", "error", "Incorrect Verification code");
        header("Location: ../View/updateuserverify.php?email=" . urlencode($email) .
            "&firstname=" . urlencode($firstname) .
            "&lastname=" . urlencode($lastname) .
            "&contact=" . urlencode($contact) .
            "&address=" . urlencode($address) .
            "&username=" . urlencode($username) . "");
        exit();

    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['LOGOUT'])) {
    // Clear the session data and destroy the session
    $_SESSION = array();
    session_destroy();

    // Redirect to the index page with a "success" message
    flash("msg", "success", "Logged out successfully");
    header("Location: ../View/index.php");
    exit();
} elseif (isset($_POST['UPDATEGCASH'])) {
    $id = $_POST['id'];
    $gName = $_POST['gcash_name'];
    $gNumber = $_POST['gcash_number'];
    if($gName != '' || $gNumber!= ''){
        $row = updateUser(
                'user_details',
                array('id', 'gcash_name','gcash_number'),
                array($id, $gName,$gNumber)
            );

        if($row){
            flash("msg", "success", "Updated Successfully");
            header("Location: ../View/gcash_info.php");
            exit();
        }else{
            flash("msg", "error", "Error");
            header("Location: ../View/gcash_info.php");
            exit();
        }
    }else{
        flash("msg", "info", "Input Something");
        header("Location: ../View/gcash_info.php");
        exit();
    }

}
?>

