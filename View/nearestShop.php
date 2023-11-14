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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI/t1W9fZ5k8n8v5QrOvGPl/YYBhT1BlU6xZMHVf8=" crossorigin="anonymous"></script>
    <style>
        #map {
            height: 80vh;
            width: 100%;
        }
    </style>
</head>

<body onload="getLocation()">
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details', 'id', $_SESSION['id']));
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav breadcrumb-with-filter">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nearest Shop</li>
                    </ol>
                </div>
            </nav>
            <div class="container mb-10">
                <div id="map" style="margin-left:38px;"></div>
            </div>
            <center>
                <h3>
                    Nearest Shops
                </h3>
            </center>
            <?php
            $v1 = $_GET['lat'];
            $v2 = $_GET['long'];
            $shop = distance($v1, $v2);
            while ($row = mysqli_fetch_array($shop)): ?>
                
                    
                    <div class="container">
                        <h6>Distance :
                        <?= number_format($row['distance'], 2) ?> km
                    </h6>
						<div class="page-header text-center mb-5" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
							<h1 class="page-title mb-5" style="color:#000; font-size:5rem!important; font-weight:500;">
								<?= $row['shop_name'] ?><span style="color:#26180b;">
									<?= $row['address'] ?>
								</span>
							</h1>
							<button class="btn btn-info"><a href="storeShop.php?shop_id=<?= $row['id'] ?>" class="text-white"> Visit Shop </a></button>
						</div>
					</div>
               
            <?php endwhile; ?>
        </main>
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php
    include("../layouts/jsfile.layout.php");
    include("toastr.php");
    include('../assets/js/prod.php');
    ?>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""> </script>
    <script>
        var map = L.map('map').setView([10.3157, 123.8854], 11);
        
        var marker = L.marker([10.3, 123.9070829]).addTo(map);
        var popup = marker.bindPopup('Sample Shop 13km away from your current location');
        popup.openPopup();
        

        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });
        osm.addTo(map);

        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        googleStreets.addTo(map);

        var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        googleSat.addTo(map);

        var OpenStreetMap_France = L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '&copy; OpenStreetMap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });
        OpenStreetMap_France.addTo(map);

        var baseLayers = {
            "OpenStreetMap": osm,
            "Satellite": googleSat,
            'Google Map': googleStreets,
            "Water Color": OpenStreetMap_France
        };

        var overlays = {
            "Marker": marker,
        };
        L.control.layers(baseLayers, overlays).addTo(map);

        var latitude, longitude;

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            console.log("Latitude: " + latitude + " Longitude: " + longitude)

            map.setView([latitude, longitude], 13);

            marker.unbindPopup();
            marker.setLatLng([latitude, longitude]);
            popup = marker.bindPopup('Your Current Location');
            popup.openPopup();

            // Call the function to find the nearest shop
            neareastShop();
        }

    </script>
</body>



</html>
