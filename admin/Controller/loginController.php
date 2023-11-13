<?php
include('../../Model/db.php');
include('../../includes/toastr.inc.php');
session_start();


if (isset($_POST['LOGIN'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = loginAdmin($username, $password);

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_username'] = $user['username'];

    echo "<script>
                alert('Login Successfully');
                window.location.href = '../View/dashboard.php';
              </script>";
  } else {
    echo "<script>
                alert('Invalid Username or Password');
                window.location.href = '../View/login.php';
              </script>";

  }
} elseif (isset($_POST['LOGOUT'])) {
  $_SESSION = array();
  session_destroy();
  echo "<script>
            alert('Logout Successfully');
            window.location.href = '../View/login.php';
          </script>";
}
