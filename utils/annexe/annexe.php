<?php
// require_once "../BD/requettes/select.php";
require_once __DIR__."/../BD/requettes/select.php";
require_once __DIR__."/../BD/requettes/update.php";

function formatetoile($nbEtoile):string {
    $nbEtoile = max(0, min(5, $nbEtoile));

    $etoilesDorees = str_repeat('★', $nbEtoile);

    $etoilesVides = str_repeat('☆', 5 - $nbEtoile);

    return '<span class="colorEtoile">' . $etoilesDorees . '</span>' . $etoilesVides;
}

function formatetoileV2($nbEtoile):string {
    $nbEtoile = max(0, min(5, $nbEtoile));

    $etoilesDorees = str_repeat('★', $nbEtoile);

    $etoilesVides = str_repeat('☆', 5 - $nbEtoile);

    return '<span class="colorEtoileNoShadow">' . $etoilesDorees . '</span>' . $etoilesVides;
}


function formatAdresse($dataResto):string {
    return ($dataResto["address"]["house_number"] ?? '') ." ".
    ($dataResto["address"]["retail"] ?? 'rue ..?') ." ".
    ($dataResto["address"]["city"] ?? '') ." ".
    ($dataResto["address"]["postcode"] ?? '') ." ".
    ($dataResto["address"]["country"] ?? '');
}

function formatUrlResto(string $id, string $name):string{
    return "pages/restaurant.php?osmID=".$id."&resto=".$name."";
}

function formatCuisine($value):string {
    // return implode(",\n",$leresto["cuisines"]);
    $cuisine= "";
    if(isset($value["cuisines"]) && !empty($value["cuisines"])){

        // foreach($value["cuisines"] as $typeResto){
            $cuisine.=implode(",\n", $value["cuisines"]);
            // echo formatCuisine($value["cuisines"]);       
        // }      
    }
    else{
        return "pas de cuisine dispo";
    }
    return $cuisine;
}

function formatAdresseCommune($value):string{
    return $value["codecommune"]??''." ".$value["nomcommune"]??'';
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


/**
 * Renvoie une liste de jours à partir d'un jour de départ et d'un jour d'arrivé
 * @param string $firstDay
 * @param string $lastDay
 * @return array
 */
function getAllDays(string $firstDay, string $lastDay):array{
    $days = ["Mo","Tu","We","Th","Fr","Sa","Su"];

    $res = [];

    $firstIndex = array_search($firstDay, $days);
    $lastIndex = array_search($lastDay, $days);

    if ($firstIndex === false || $lastIndex === false) {
        return [];
    }

    for ($i=$firstIndex; $i < $lastIndex+1; $i++) { 
        array_push($res, $days[$i]);
    }

    return $res;
}

/**
 * Transforme un string d'heure d'ouverture en liste de jour et de créneau horaire
 * @param string $opening
 * @return array Liste de liste contenant une liste de jours et une liste d'horaires 
 */
function transformOpeningHours(string $opening):array{
    $res = [];

    $lesHoraires = explode("; ",$opening);
    foreach ($lesHoraires as $value) {
        $truc = [];
        $temp = explode(" ", $value,2);
        // $tempJour1 = explode(",",$temp[0]);
        $lesJours = [];
        foreach(explode(",",$temp[0]) as $key => $value) {
            $oui = [];
            $tempJour = explode("-",$value);
            if(sizeof($tempJour)>1){
                $oui= getAllDays($tempJour[0],$tempJour[1]);
            }
            else{
                $oui= $tempJour;
            }

            $lesJours = array_merge($lesJours, $oui);
        }
        $truc["jours"] = $lesJours;
        $truc["heures"] = [];

        if(! empty($truc["jours"])){
            if(sizeof($temp)>1){
                $temp[1] = str_replace(" ", "",$temp[1]);
                $tempHeures = explode(",",$temp[1]);
    
                foreach($tempHeures as $uneHeure){
                    $resUneHeure = [];
                    $tempUneHeure = explode("-", $uneHeure);
                    $resUneHeure["debut"] = $tempUneHeure[0];
                    if(sizeof($tempUneHeure)>1){
                        $resUneHeure["fin"] = $tempUneHeure[1];
                    }
                    else{
                        $resUneHeure["fin"] = "00:00";
                    }
    
                    array_push($truc["heures"],$resUneHeure);
                }
            }
            else{
                $resUneHeure["debut"] = "00:00";
                $resUneHeure["fin"] = "00:00";
                // $resUneHeure["fin"] = null;

                array_push($truc["heures"],$resUneHeure);
            }

            array_push($res,$truc);
        }

    }
    return $res;
}



function getPlaceId(float $lat, float $lng, string $name, int $rad = 10){ 
    $apiKey = getAPIKey();
    $placeId = "";
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$apiKey&location=$lat,$lng&radius=$rad";
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    // echo "<pre>";
    // print_r($data["results"]);
    // echo "</pre>";
    
    try{
        if(isset($data["results"]) || !empty($data["results"]) ){

            foreach($data["results"] as $resto){
                // echo $resto["$resto"]
                // foreach($resto as $val) {
                    //     if (is_string($val)) {
                        //         $val = json_decode($val, true); // true pour obtenir un tableau associatif
                        //     }
                        
                if ($resto["name"]==$name){
                    $placeId = $resto["place_id"];
                    break;
                    // }
                }
        }
    }
    } catch( Exception $e ){
        // Juste parce que le foreach resto fait nimp
    }
    return $placeId;
}

function getImageByPlaceId(PDO $bdd, string $osmid, string $placeId):array{

    $lesimages = getImagesResto($bdd, $osmid);
    if(!empty($lesimages["vertical"]) && !empty($lesimages["horizontal"])  ){
        

        return $lesimages;
    }else{
        

        $apiKey = getAPIKey();
        $url_img = "https://maps.googleapis.com/maps/api/place/details/json?place_id=$placeId&fields=name,photos&key=$apiKey";

        $response_img = file_get_contents($url_img);
        $data_img = json_decode($response_img, true);
        
        // if (!$data_img || $data_img['status'] !== "OK") {
        //     die(json_encode(["error" => "Aucun résultat trouvé ou erreur API.", "status" => $data_img['status'] ?? "Unknown"]));
        // }
        
        $photos = [];
        if (!empty($data_img['result']['photos'])) {
            foreach ($data_img['result']['photos'] as $photo) {
                $photoRef = $photo['photo_reference'];
                $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference=$photoRef&key=$apiKey";
                $photos[] = $photoUrl;
            }
        }
        if(empty($photo)){
            return[];
        }
        // header('Content-Type: application/json');
        $lesimages = categorizeImagesByOrientation($photos);
      
        if(!empty($lesimages["vertical"]) && !empty($lesimages["horizontal"])  ){
            
            echo ("insert image dans la bd");
            addImageRestaurantById($bdd, $osmid, $lesimages["horizontal"][0], $lesimages["vertical"][0]);
        }
        return $lesimages;
    }

}

function categorizeImagesByOrientation($imageUrls) {
    $categorizedImages = [
        'vertical' => [],
        'horizontal' => [],
    ];

    foreach ($imageUrls as $imageUrl) {
        // Télécharger l'image depuis l'URL
        $imageData = file_get_contents($imageUrl);

        if ($imageData === false) {
            continue; // Passer à l'image suivante si erreur
        }

        // Obtenir les dimensions de l'image
        $imageSize = getimagesizefromstring($imageData);

        if ($imageSize === false) {
            continue; // Passer à l'image suivante si erreur
        }

        $width = $imageSize[0];
        $height = $imageSize[1];

        // Classer l'image en fonction de l'orientation
        if ($width > $height) {
            $categorizedImages['horizontal'][] = $imageUrl;
        } else {
            $categorizedImages['vertical'][] = $imageUrl;
        }
    }

    return $categorizedImages;
}
