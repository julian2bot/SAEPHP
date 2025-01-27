<?php
    require_once __DIR__."/../connexionBD.php";

    function getRegion(PDO $bdd, $codeRegion):array{
        $reqResto = $bdd->prepare("SELECT * FROM REGION WHERE codeRegion = ?");
        $reqResto->execute(array($codeRegion));

        $info = $reqResto->fetch();
        if(!$info){
            return[];
        }
        return $info;
    }

    function getDepartement(PDO $bdd, $codeRegion, $codeDepartement):array{
        $reqResto = $bdd->prepare("SELECT * FROM DEPARTEMENT WHERE codeRegion = ? AND codeDepartement = ?");
        $reqResto->execute(array($codeRegion, $codeDepartement));

        $info = $reqResto->fetch();
        if(!$info){
            return[];
        }
        return $info;
    }

    function getCommune(PDO $bdd, $codeRegion, $codeDepartement, $codeCommune):array{
        $reqResto = $bdd->prepare("SELECT * FROM COMMUNE WHERE codeRegion = ? AND codeDepartement = ? AND codeCommune = ?");
        $reqResto->execute(array($codeRegion, $codeDepartement, $codeCommune));

        $info = $reqResto->fetch();
        if(!$info){
            return[];
        }
        return $info;
    }

    function getRestaurantByID(PDO $bdd, $osmID):array{
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT WHERE osmID = ?");
        $reqResto->execute(array($osmID));

        $info = $reqResto->fetch();
        if(!$info){
            return[];
        }
        return $info;
    }

    function getRestaurantBySiret(PDO $bdd, $siret):array{
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT WHERE siret = ?");
        $reqResto->execute(array($siret));

        $info = $reqResto->fetch();
        if(!$info){
            return[];
        }
        return $info;
    }
?>