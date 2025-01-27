<?php
    require_once __DIR__."/../BD/connexionBD.php";
    require_once __DIR__."/readJson.php";
    require_once __DIR__."/../BD/requettes/insert.php";

    echo "<pre>";
    $lesRestaurants = getData();
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
        createRegion($bdd,$resto["code_region"], $resto["region"]);
        createDepartement($bdd, $resto["code_region"], $resto["code_departement"], $resto["departement"]);
        $codeCommune = $resto["code_commune"] ?? $resto["com_insee"];
        $nomCommune = $resto["commune"] ?? $resto["com_nom"];
        createCommune($bdd, $resto["code_region"], $resto["code_departement"],$codeCommune,$nomCommune);
        return true;
    }

    function addAllRestoFromJson(PDO $bdd, array $lesRestos){
        foreach ($lesRestos as $resto) {
            addRestoFromJson($bdd, $resto);
        }
    }

    addAllRestoFromJson($bdd,$lesRestaurants);
?>