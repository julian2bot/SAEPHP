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
        $tel = $resto["phone"] ?? "";
        $siret = $resto["siret"] ?? "";
        $etoiles = $resto["stars"] ?? -1;
        $siteInternet = $resto["website"] ?? "";
        createRestaurant($bdd,$resto["osm_id"],$resto["name"],$tel, $siret,$etoiles,$siteInternet, $codeCommune);

        // Services
        $vegetarian = $resto["vegetarian"] ?? "";
        if($vegetarian != "" && in_array($vegetarian,["yes","no"])){
            insertServicePropose($bdd,$resto["osm_id"],"vegetarian",($resto["vegetarian"] == "yes"));
        }
        $vegan = $resto["vegan"] ?? "";
        if($vegan != "" && in_array($vegan,["yes","no"])){
            insertServicePropose($bdd,$resto["osm_id"],"vegan",($resto["vegan"] == "yes"));
        }
        $delivery = $resto["delivery"] ?? "";
        if($delivery != "" && in_array($delivery,["yes","no"])){
            insertServicePropose($bdd,$resto["osm_id"],"delivery",($resto["delivery"] == "yes"));
        }
        $takeaway = $resto["takeaway"] ?? "";
        if($takeaway != "" && in_array($takeaway,["yes","no"])){
            insertServicePropose($bdd,$resto["osm_id"],"takeaway",($resto["takeaway"] == "yes"));
        }
        $internet = $resto["internet_access"] ?? "";
        if($internet != "" && in_array($internet,["yes","no"])){
            insertServicePropose($bdd,$resto["osm_id"],"internet_access",($resto["internet_access"] == "yes"));
        }
        $drive = $resto["drive_through"] ?? "";
        if($drive != "" && in_array($drive,["yes","no"])){
            insertServicePropose($bdd,$resto["osm_id"],"drive_through",($resto["drive_through"] == "yes"));
        }

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