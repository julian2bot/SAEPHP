<?php
    require_once __DIR__."/../connexionBD.php";

    /**
     * Renvoie une région par son code de région
     * @param PDO $bdd
     * @param string $codeRegion
     * @return array région ou liste vide si elle n'existe pas
     */
    function getRegion(PDO $bdd, string $codeRegion):array{
        $reqResto = $bdd->prepare("SELECT * FROM REGION WHERE codeRegion = ?");
        $reqResto->execute(array($codeRegion));

        $info = $reqResto->fetch();
        if(!$info){
            return [];
        }
        return $info;
    }

    /**
     * Renvoie un département par son code de département
     * @param PDO $bdd
     * @param string $codeDepartement
     * @return array département ou liste vide s'il n'existe pas
     */
    function getDepartement(PDO $bdd, string $codeDepartement):array{
        $reqResto = $bdd->prepare("SELECT * FROM DEPARTEMENT WHERE codeDepartement = ?");
        $reqResto->execute(array($codeDepartement));

        $info = $reqResto->fetch();
        if(!$info){
            return [];
        }
        return $info;
    }

    /**
     * Renvoie une commune par son code de commune
     * @param PDO $bdd
     * @param string $codeCommune
     * @return array commune ou liste vide si elle n'existe pas
     */
    function getCommune(PDO $bdd, string $codeCommune):array{
        $reqResto = $bdd->prepare("SELECT * FROM COMMUNE WHERE codeCommune = ?");
        $reqResto->execute(array($codeCommune));

        $info = $reqResto->fetch();
        if(!$info){
            return [];
        }
        return $info;
    }

    /**
     * Renvoie les informations d'un restaurant
     * @param PDO $bdd
     * @param string $osmID
     * @return array informations du restaurant ou liste vide s'il n'existe pas
     */
    function getRestaurantByID(PDO $bdd, string $osmID):array{
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT WHERE osmID = ?");
        $reqResto->execute(array($osmID));

        $info = $reqResto->fetch();
        if(!$info){
            return [];
        }
        $info["cuisines"] = getCuisineByResto($bdd,$osmID);
        return $info;
    }

    /**
     * Renvoie une liste des noms de cuisines proposés par un resto
     * @param PDO $bdd
     * @param string $osmID
     * @return array
     */
    function getCuisineByResto(PDO $bdd, string $osmID):array{
        $reqResto = $bdd->prepare("SELECT nomCuisine FROM PROPOSE NATURAL JOIN CUISINE WHERE osmID = ?");
        $reqResto->execute(array($osmID));

        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }
        $res = [];
        foreach($info as $val){
            array_push($res, $val["nomcuisine"]);
        }
        return $res;
    }

    /**
     * Renvoie l'id d'une cuisine en fonction de son nom
     * @param PDO $bdd
     * @param string $nomCuisine
     * @return int id de la cuisine, -1 si elle n'existe pas
     */
    function getCuisineId(PDO $bdd, string $nomCuisine):int{
        $reqResto = $bdd->prepare("SELECT * FROM CUISINE WHERE nomCuisine = ?");
        $reqResto->execute(array($nomCuisine));

        $info = $reqResto->fetch();
        if(!isset($info["idcuisine"])){
            return -1;
        }
        return $info["idcuisine"];
    }

    /**
     * Renvoie le prochain id de cuisine
     * @param PDO $bdd
     * @return int
     */
    function getNextCuisineID(PDO $bdd):int{
        $reqResto = $bdd->prepare("SELECT max(idCuisine) as max FROM CUISINE");
        $reqResto->execute(array());

        $info = $reqResto->fetch();
        if(!isset($info["max"])){
            return 0;
        }
        return $info["max"]+1;
    }

    /**
     * Renvoie la liste des cuisines proposés par un restaurants
     * @param PDO $bdd
     * @param string $osmID
     * @return array liste de string des noms de cuisines proposés
     */
    function getCuisinePropose(PDO $bdd, string $osmID):array{
        $propose = [];
        $reqResto = $bdd->prepare("SELECT * FROM PROPOSE NATURAL JOIN CUISINE WHERE osmID = ?");
        $reqResto->execute(array($osmID));
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }
        foreach ($info as $cuisine) {
            array_push($propose,$cuisine["nomcuisine"]);
        }
        return $propose;
    }
?>