<?php


function formatetoile($nbEtoile):string {
    $nbEtoile = max(0, min(5, $nbEtoile));

    $etoilesDorees = str_repeat('★', $nbEtoile);

    $etoilesVides = str_repeat('☆', 5 - $nbEtoile);

    return '<span class="colorEtoile">' . $etoilesDorees . '</span>' . $etoilesVides;
}


function formatAdresse($dataResto):string {
    return $dataResto["address"]["house_number"] ." ". $dataResto["address"]["retail"] ." ". $dataResto["address"]["city"]  ." ". $dataResto["address"]["postcode"] ." ".$dataResto["address"]["country"];
}



function formatCuisine($leresto):string {
    return implode(",\n",$leresto["cuisines"]);
}

function formatAdresseCommune($value):string{
    return $value["codeCommune"]." ".$value["nomCommune"];
}

function getAPIKey():string {
    $passCsv = fopen( __DIR__ . '/pass.csv', 'r');
    if (!feof($passCsv)) {
        $replace = [";","\n","\r","\r\n"];

        return str_replace($replace,"",fgets($passCsv)) ;
    }
    return '';
}

function getImageRestoByCo(float $lat, float $lon):void {

    $apiKey = " ";
    if($apiKey === ""){
        return ;
    }
    $location = "$lat,$lon";
    $radius = 15; // Rayon de recherche en mètres
    $type = 'restaurant';

    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$location&radius=$radius&type=$type&key=$apiKey";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['status'] == 'OK') {
        foreach ($data['results'] as $restaurant) {
            echo 'Nom: ' . $restaurant['name'] . '<br>';
            if (isset($restaurant['photos'])) {
                $photoReference = $restaurant['photos'][0]['photo_reference'];
                $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=$photoReference&key=$apiKey";
                echo '<img src="' . $photoUrl . '" alt="' . $restaurant['name'] . '"><br>';
            }
        }
    } else {
        echo 'Erreur: ' . $data['status'];
    }
}



function getRestaurantInfoByCo(float $lat, float $lon):array {

    
    $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lon";
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: PHP\r\n"
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    if ($response === FALSE) {
        die('Error');
    }
    
    $dataResto = json_decode($response, true);
    return $dataResto;
}



function lienItineraire(float $lat, float $lon):string {
    return  "https://www.google.com/maps/dir/?api=1&destination=$lat,$lon";
}