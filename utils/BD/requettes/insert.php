<?php
    require_once __DIR__."/../connexionBD.php";
    require_once __DIR__."/get.php";

    /**
     * Créer une région si elle n'existe pas encore
     * @param PDO $bdd
     * @param int $codeRegion id de la région ex 24
     * @param string $nomRegion
     * @return bool true si l'insertion s'est déroullé avec succès
     */
    function createRegion(PDO $bdd, int $codeRegion, string $nomRegion):bool{
        if(! empty(getRegion($bdd, $codeRegion))){
            return false;
        }

        $reqResto = $bdd->prepare("INSERT INTO REGION (codeRegion,nomRegion) VALUES (?,?)");
        $reqResto->execute(array($codeRegion,$nomRegion));

        return true;
    }

    /**
     * Créer un département si il n'existe pas encore
     * @param PDO $bdd
     * @param int $codeRegion id de la région ex 24
     * @param int $codeDepartement id du département ex 45
     * @param string $nomDepartement
     * @return bool true si l'insertion s'est déroullé avec succès
     */
    function createDepartement(PDO $bdd, int $codeRegion, int $codeDepartement, string $nomDepartement):bool{
        if(! empty(getDepartement($bdd, $codeRegion,$codeDepartement))){
            return false;
        }

        $reqResto = $bdd->prepare("INSERT INTO DEPARTEMENT (codeRegion,codeDepartement,nomDepartement) VALUES (?,?,?)");
        $reqResto->execute(array($codeRegion,$codeDepartement,$nomDepartement));
        return true;
    }

    /**
     * Créer une commune si elle n'existe pas encore
     * @param PDO $bdd
     * @param int $codeRegion id de la région ex 24
     * @param int $codeDepartement id du département ex 45
     * @param int $codeCommune id de la commune ex 45000
     * @param string $nomCommune
     * @return bool true si l'insertion s'est déroullé avec succès
     */
    function createCommune(PDO $bdd, int $codeRegion, int $codeDepartement, int $codeCommune, string $nomCommune):bool{
        if(! empty(getCommune($bdd, $codeRegion,$codeDepartement, $codeCommune))){
            return false;
        }

        $reqResto = $bdd->prepare("INSERT INTO COMMUNE (codeRegion,codeDepartement,codeCommune, nomCommune) VALUES (?,?,?,?)");
        $reqResto->execute(array($codeRegion,$codeDepartement,$codeCommune, $nomCommune));
        return true;
    }
?>