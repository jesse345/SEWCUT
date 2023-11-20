<?php
include("../Model/db.php");
session_start();

if (!isset($_SESSION['id'])) {
	header("Location: ../index.php");
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("../layouts/head.layout.php") ?>
	<title>My Product</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body onload="getLocation()">
	<?php
	$user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
	$saveAddress = mysqli_fetch_assoc(getrecord('address', 'id', $user['address']))
	?>
	<div class="page-wrapper">
		<?php include("../layouts/header_layout.php"); ?>
		<main class="main">
			<nav aria-label="breadcrumb" class="breadcrumb-nav breadcrumb-with-filter">
				<div class="container">
					<form action="../Controller/shopController.php" method="POST">
						<input type="hidden" name="lats" id="lats" value="">
        				<input type="hidden" name="longs" id="longs" value="">
						<button type="submit" name="NEARESTSHOP"
							style="border:none;background-color:transparent;font-size:16px;"><i
								class="icon-bars"></i>Nearest
							Shop</button>
					</form>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Shop</li>
					</ol>
				</div>
			</nav>
			<?php $shop = displayShop();
			while ($row = mysqli_fetch_array($shop)): 
					?>
					<div class="container">
						<div class="page-header text-center mb-5" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
							<h1 class="page-title mb-5" style="color:#000; font-size:5rem!important; font-weight:500;">
								<?= $row['shop_name'] ?><span style="color:#26180b;">
									<?= $row['address'] ?>
								</span>
							</h1>
							<?php if($row['user_id'] == $user['id']){?>
								<button class="btn btn-info"><a class="text-white" href="myShop.php"> Your Shop </a></button>
							<?php }else{?>
								<button class="btn btn-info"><a href="storeShop.php?shop_id=<?= $row['id'] ?>" class="text-white"> Visit Shop </a></button>
							<?php }?>
						</div>
					</div>
			<?php endwhile; ?>
		</main>
		<br>
		<?php include("../layouts/footer.layout1.php"); ?>
	</div>

	
	<?php
	include("../layouts/jsfile.layout.php");
	?>
	 <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // function showError(error) {
		// 	console.error(error.message);
		// 	switch (error.code) {
		// 		case error.PERMISSION_DENIED:
		// 			alert("To use this feature, please enable location services for this site. Check your browser settings to allow access to your location.");
		// 			break;
		// 		case error.POSITION_UNAVAILABLE:
		// 			alert("Location information is unavailable. Please make sure your device's location services are enabled.");
		// 			break;
		// 		case error.TIMEOUT:
		// 			alert("The request to get your location timed out. Please try again.");
		// 			break;
		// 		case error.UNKNOWN_ERROR:
		// 			alert("An unknown error occurred. Please try again later.");
		// 			break;
		// 	}
		// }


        function showPosition(position) {
            $("#lats").val(position.coords.latitude);
            $("#longs").val(position.coords.longitude);
        }

        $(document).ready(function () {
            getLocation();
        });
    </script>
</body>

</html>
