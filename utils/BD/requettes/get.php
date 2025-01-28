<?php
    require_once __DIR__."/../connexionBD.php";

    /**
     * Renvoie une région par son code de région
     * @param PDO $bdd
     * @param int $codeRegion
     * @return array région ou liste vide si elle n'existe pas
     */
    function getRegion(PDO $bdd, int $codeRegion):array{
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
     * @param int $codeDepartement
     * @return array département ou liste vide s'il n'existe pas
     */
    function getDepartement(PDO $bdd, int $codeDepartement):array{
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
     * @param int $codeCommune
     * @return array commune ou liste vide si elle n'existe pas
     */
    function getCommune(PDO $bdd, int $codeCommune):array{
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
        return $info;
    }

    /**
     * Renvoie l'id d'un service en fonction de son nom
     * @param PDO $bdd
     * @param string $serviceName
     * @return int id du service, -1 s'il n'existe pas
     */
    function getServiceID(PDO $bdd, string $serviceName):int{
        $reqResto = $bdd->prepare("SELECT * FROM SERVICE WHERE nomService = ?");
        $reqResto->execute(array($serviceName));

        $info = $reqResto->fetch();
        if(!isset($info["idservice"])){
            return -1;
        }
        return $info["idservice"];
    }

    /**
     * Renvoie la liste des services proposés par un restaurants
     * @param PDO $bdd
     * @param string $osmID
     * @return array liste de string des noms de services proposés
     */
    function getServicePropose(PDO $bdd, string $osmID):array{
        $propose = [];
        $reqResto = $bdd->prepare("SELECT * FROM SERVICE_PROPOSE NATURAL JOIN SERVICE WHERE osmID = ?");
        $reqResto->execute(array($osmID));
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }
        foreach ($info as $service) {
            array_push($propose,$service["nomservice"]);
        }
        return $propose;
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