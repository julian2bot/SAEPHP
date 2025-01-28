<?php
    require_once __DIR__."/../connexionBD.php";

    function getRegion(PDO $bdd, int $codeRegion):array{
        $reqResto = $bdd->prepare("SELECT * FROM REGION WHERE codeRegion = ?");
        $reqResto->execute(array($codeRegion));

        $info = $reqResto->fetch();
        if(!$info){
            return [];
        }
        return $info;
    }

    function getDepartement(PDO $bdd, int $codeDepartement):array{
        $reqResto = $bdd->prepare("SELECT * FROM DEPARTEMENT WHERE codeDepartement = ?");
        $reqResto->execute(array($codeDepartement));

        $info = $reqResto->fetch();
        if(!$info){
            return [];
        }
        return $info;
    }

    function getCommune(PDO $bdd, int $codeCommune):array{
        $reqResto = $bdd->prepare("SELECT * FROM COMMUNE WHERE codeCommune = ?");
        $reqResto->execute(array($codeCommune));

        $info = $reqResto->fetch();
        if(!$info){
            return [];
        }
        return $info;
    }

    function getRestaurantByID(PDO $bdd, string $osmID):array{
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT WHERE osmID = ?");
        $reqResto->execute(array($osmID));

        $info = $reqResto->fetch();
        if(!$info){
            return [];
        }
        return $info;
    }

    function getServiceID(PDO $bdd, string $serviceName):int{
        $reqResto = $bdd->prepare("SELECT * FROM SERVICE WHERE nomService = ?");
        $reqResto->execute(array($serviceName));

        $info = $reqResto->fetch();
        if(!isset($info["idservice"])){
            return -1;
        }
        return $info["idservice"];
    }
?>