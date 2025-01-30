<?php
    /**
     * Renvoie un Json sous forme d'array via le chemin d'un fichier donné en paramètre
     * @param string $file chemin du fichier
     * @return array json
     */
    function getJson(string $file):array{
        $file = file_get_contents($file);
        return json_decode(json: $file,associative: true);
    }
    
    function getData(string $file=__DIR__."/../../assets/data/restaurants_orleans.json"):array{
        return getJson($file);
    }
?>