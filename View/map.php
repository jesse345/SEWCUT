<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map{
            height:100vh;
            width:100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
</body>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    var map = L.map('map').setView([10.3157, 123.8854], 11);

    // OSM Layer
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    // Marker
    var marker = L.marker([10.3405524, 123.9070829]);
    var popup = marker.bindPopup('Sample Shop 13km away form your current location');
    marker.addTo(map);

    // Open the popup automatically
    popup.openPopup();

    

    // Tile Layer
    var OpenStreetMap_France = L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: '&copy; OpenStreetMap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    OpenStreetMap_France.addTo(map);
    
    //Google Map Layer
    googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    });
    googleStreets.addTo(map);

    //SAtelite Layer
    googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    });
    googleSat.addTo(map);

    //LAyer Control
    var baseLayers = {
        "OpenStreetMap": osm,
        "Satellite": googleSat,
        'Google Map': googleStreets,
        "Water Color":OpenStreetMap_France
    };

    var overlays = {
        "Marker": marker,  
    };
    L.control.layers(baseLayers, overlays).addTo(map);

    
</script>
</html>