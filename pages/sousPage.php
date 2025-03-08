<?php
    if(!isset($_SESSION)){
        session_start();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carte des restaurants</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <script src="../assets/script/popUpGestionErr.js"></script>
    <style>
        #map {
            height: 450px;
            width: 600px;
        }
    </style>
</head>
<body>

<?php
// Exemple de données de restaurants
$restaurants = [
    ["name" => "Restaurant 1", "lat" => 47.9011497999612, "lon" => 1.9052942],
    ["name" => "Restaurant 2", "lat" => 47.9021497999612, "lon" => 1.9062942]
];
?>
    <h1>Carte des restaurants</h1>
    <div id="map"></div>
    <script>
        var map = L.map('map').setView([47.9011497999612, 1.9052942], 18);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Ajouter des marqueurs pour les restaurants
        // var restaurants = [
        //     { name: "Restaurant 1", lat: 47.9011497999612, lon: 1.9052942 },
        // ];
        var restaurants = <?php echo json_encode($restaurants); ?>;


        restaurants.forEach(function(restaurant) {
            L.marker([restaurant.lat, restaurant.lon]).addTo(map)
                .bindPopup(restaurant.name)
                .openPopup();
        });
    </script>
</body>
</html>

<?php
// Coordonnées du restaurant
$latitude = 47.9011497999612;
$longitude = 1.9052942;

// URL de Google Maps pour l'itinéraire
$googleMapsUrl = "https://www.google.com/maps/dir/?api=1&destination=$latitude,$longitude";
?>


<h1>Itinéraire vers le restaurant</h1>
    <p>Cliquez sur le lien ci-dessous pour obtenir l'itinéraire vers le restaurant :</p>
    <a href="<?php echo $googleMapsUrl; ?>" target="_blank">Obtenir l'itinéraire</a>

    <?php
$apiKey = ' ';
$location = '47.90117280724346,1.9052290530795803';
$radius = 5000; // Rayon de recherche en mètres
$type = 'restaurant';

$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$location&radius=$radius&key=$apiKey";
echo "<pre>";

$response = file_get_contents($url);
$data = json_decode($response, true);
print_r($data);
echo "</pre>";

if ($data['status'] == 'OK') {
    foreach ($data['results'] as $restaurant) {
        echo 'Nom: ' . $restaurant['name'] . '<br>';
        if (isset($restaurant['photos'])) {
            $photoReference = $restaurant['photos'][0]["photo_reference"];
            print_r($restaurant['photos'][0]);
            $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=$photoReference&key=$apiKey";
            echo '<img src="' . $photoUrl . '" alt="' . $restaurant['name'] . '"><br>';
        }
    }
} else {
    echo 'Erreur: ' . $data['status'];
}
?>
