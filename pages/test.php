<?php
$apiKey = "AIzaSyBTyD0V18SbGWwRq7sMZ7e4XyGD4DIUxa4"; // API
$lat = "47.90114979996115";
$lng = "1.9052942";
$rad = "10";
$name = "Cha+";

$placeId = "";



// 
// récupération id resto
// 
$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$apiKey&location=$lat,$lng&radius=$rad";
$response = file_get_contents($url);
$data = json_decode($response, true);
try{
    foreach($data as $resto){
        // echo $resto["$resto"]
        foreach($resto as $val) {
            // echo "<pre>";
            // print_r($val);
            // echo "</pre>";
            if ($val["name"]==$name){
                $placeId = $val["place_id"];
                break;
            }
        }
    }
} catch( Exception $e ){
    // Juste parce que le foreach resto fait chier
}


// 
// récupération photos resto
// 
$url_img = "https://maps.googleapis.com/maps/api/place/details/json?place_id=$placeId&fields=name,photos&key=$apiKey";

$response_img = file_get_contents($url_img);
$data_img = json_decode($response_img, true);

if (!$data_img || $data_img['status'] !== "OK") {
    die(json_encode(["error" => "Aucun résultat trouvé ou erreur API.", "status" => $data_img['status'] ?? "Unknown"]));
}

$photos = [];
if (!empty($data_img['result']['photos'])) {
    foreach ($data_img['result']['photos'] as $photo) {
        $photoRef = $photo['photo_reference'];
        $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference=$photoRef&key=$apiKey";
        $photos[] = $photoUrl;
    }
}

header('Content-Type: application/json');
echo json_encode(["name" => $data_img['result']["name"], "photos" => $photos], JSON_PRETTY_PRINT);


?>

