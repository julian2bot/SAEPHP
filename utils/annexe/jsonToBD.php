<?php
    require_once __DIR__."/../BD/connexionBD.php";
    require_once __DIR__."/readJson.php";

    echo "<pre>";
    $lesRestaurants = getData();
    print_r($lesRestaurants);
    echo "</pre>";

    /** 
     * Ajoute un restaurant à la BD via un JSON
     * 
     * @return bool Si l'ajout a pu se faire 
    */
    function addRestoFromJson(array $resto) : bool{
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
        
    }
?>