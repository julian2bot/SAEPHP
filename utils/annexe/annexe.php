<?php



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

require_once __DIR__."/../BD/connexionBD.php";

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
?>
