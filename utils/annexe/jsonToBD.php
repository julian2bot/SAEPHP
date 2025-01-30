<?php
    require_once __DIR__."/../BD/connexionBD.php";
    require_once __DIR__."/readJson.php";
    require_once __DIR__."/../BD/requettes/insert.php";

    echo "<pre>";
    $lesRestaurants = getData();
    // $lesRestaurants = getData(__DIR__."/../../assets/data/restaurants_orleans_modif.json");
    // print_r($lesRestaurants);
    echo "</pre>";

    /** 
     * Ajoute un restaurant à la BD via un JSON
     * 
     * @return bool Si l'ajout a pu se faire 
    */
    function addRestoFromJson(PDO $bdd, array $resto) : bool{
        if(! isset($resto["osm_id"]) ||
            (! isset($resto["code_commune"]) || ! isset($resto["com_insee"])) ||
            (! isset($resto["commune"]) || ! isset($resto["com_nom"])) ||
            ! isset($resto["code_departement"]) ||
            ! isset($resto["departement"]) ||
            ! isset($resto["code_region"]) ||
            ! isset($resto["region"]) ||
            ! isset($resto["type"]) ||
            ! isset($resto["name"]) ||

            empty($resto["osm_id"]) ||
            (empty($resto["code_commune"]) || empty($resto["com_insee"])) ||
            (empty($resto["commune"]) || empty($resto["com_nom"])) ||
            empty($resto["code_departement"]) ||
            empty($resto["departement"]) ||
            empty($resto["code_region"]) ||
            empty($resto["region"]) ||
            empty($resto["type"]) ||
            empty($resto["name"])
            ){
                return false;
            }

        // localisation

        createRegion($bdd,$resto["code_region"], $resto["region"]);
        createDepartement($bdd, $resto["code_region"], $resto["code_departement"], $resto["departement"]);
        $codeCommune = $resto["code_commune"] ?? $resto["com_insee"];
        $nomCommune = $resto["commune"] ?? $resto["com_nom"];
        createCommune($bdd, $resto["code_departement"],$codeCommune,$nomCommune);

        // Resto
        $tel = $resto["phone"] ?? null;
        $siret = $resto["siret"] ?? null;
        $etoiles = $resto["stars"] ?? null;
        $etoiles = ($resto["stars"] != null && $resto["stars"]>=0 && $resto["stars"]<=5) ? $resto["stars"] : null;
        $siteInternet = $resto["website"] ?? null;

        $vegetarian = $resto["vegetarian"] ?? null;
        $vegan = $resto["vegan"] ?? null;
        $delivery = $resto["delivery"] ?? null;
        $takeaway = $resto["takeaway"] ?? null;
        $internet = $resto["internet_access"] ?? null;
        $drive = $resto["drive_through"] ?? null;

        if($internet != null){
            $internet = $internet[0];
        }

        $infoResto = [];

        array_push($infoResto,$resto["osm_id"]);
        array_push($infoResto,$resto["name"]);
        array_push($infoResto,$tel);
        array_push($infoResto,$siret);
        array_push($infoResto,$etoiles);
        array_push($infoResto,$siteInternet);

        array_push($infoResto,$codeCommune);
        
        array_push($infoResto,$vegetarian);
        array_push($infoResto,$vegan);
        array_push($infoResto,$delivery);
        array_push($infoResto,$takeaway);
        array_push($infoResto,$drive);
        array_push($infoResto,$internet);

        $capacite = $resto["capacity"] ?? null;
        array_push($infoResto,$capacite);

        array_push($infoResto,$resto["brand"] ?? null);
        array_push($infoResto,$resto["operator"] ?? null);
        array_push($infoResto,$resto["type"] ?? null);
        array_push($infoResto,$resto["wikidata"] ?? null);
        array_push($infoResto,$resto["brand_wikidata"] ?? null);

        array_push($infoResto,$resto["smoking"] ?? null);
        array_push($infoResto,$resto["wheelchair"] ?? null);
        array_push($infoResto,$resto["facebook"] ?? null);

        array_push($infoResto,strval($resto["geo_point_2d"]["lon"]) ?? null);
        array_push($infoResto,strval($resto["geo_point_2d"]["lat"]) ?? null);

        createRestaurant($bdd,$infoResto);

        // Cuisines proposés

        if(isset($resto["cuisine"]) && $resto["cuisine"] !== null && !empty($resto["cuisine"])){
            foreach ($resto["cuisine"] as $cuisine) {
                insertCuisinePropose($bdd,$resto["osm_id"],$cuisine);
            }
        }

        // Horaires d'ouvertures

        if(isset($resto["opening_hours"]) && $resto["opening_hours"] !== null){
            insertHoraires($bdd, $resto["osm_id"], $resto["opening_hours"]);
        }

        return true;
    }

    function addAllRestoFromJson(PDO $bdd, array $lesRestos){
        set_time_limit(300); // 5 minutes
        foreach ($lesRestos as $resto) {
            addRestoFromJson($bdd, $resto);
        }
        set_time_limit(120);
    }

    echo "<pre>";
    addAllRestoFromJson($bdd,$lesRestaurants);
    echo "<pre>";
?>