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
        $info["cuisines"] = getCuisinePropose($bdd,$osmID);
        return $info;
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

    /**
     * Fonctions renvoyant les différents types de restaurations
     * @param PDO $bdd
     * @return array liste des noms de types
     */
    function getAllTypeResto(PDO $bdd):array{
        $reqResto = $bdd->prepare("SELECT DISTINCT type FROM RESTAURANT");
        $reqResto->execute(array());
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }

        $res = [];
        foreach ($info as $type) {
            array_push($res,$type["type"]);
        }
        return $res;
    }

    /**
     * Renvoie les restos par types de restos
     * @param PDO $bdd
     * @param string $type
     * @return array
     */
    function getRestoByType(PDO $bdd, string $type):array{
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT WHERE type=?");
        $reqResto->execute(array($type));
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }
        return $info;
    }

    /**
     * Fonctions renvoyant les différentes cuisines
     * @param PDO $bdd
     * @return array liste des noms des différentes cuisines
     */
    function getAllCuisinesResto(PDO $bdd):array{
        $reqResto = $bdd->prepare("SELECT DISTINCT nomCuisine FROM CUISINE");
        $reqResto->execute(array());
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }

        $res = [];
        foreach ($info as $cuisine) {
            array_push($res,$cuisine["nomcuisine"]);
        }
        return $res;
    }

    /**
     * Fonction renvoyant les différentes marques
     * @param PDO $bdd
     * @return array liste des noms des marque
     */
    function getAllMarques(PDO $bdd):array{
        $reqResto = $bdd->prepare("SELECT DISTINCT marque FROM RESTAURANT");
        $reqResto->execute(array());
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }

        $res = [];
        foreach ($info as $type) {
            if($type["marque"] != null)
                array_push($res,$type["marque"]);
        }
        return $res;
    }

    /**
     * Fonction renvoyant la liste des restos pour une marque
     * @param PDO $bdd
     * @param string $marque
     * @return array
     */
    function getRestoByMarque(PDO $bdd, string $marque):array{
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT WHERE marque=?");
        $reqResto->execute(array($marque));
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }

        return $info;
    }

    /**
     * Renvoie les restaurants proposant les cuisines par une liste de cuisines
     * Liste trié par ordre de cuisines correspondantes dans l'ordre décroissante (Plus de correspondance en premier)
     * @param PDO $bdd
     * @param array $cuisines
     * @return array
     */
    function getRestoByCuisine(PDO $bdd, array $cuisines):array{
        $requete = "SELECT DISTINCT osmID, count(osmID) as nb FROM PROPOSE NATURAL JOIN CUISINE WHERE nomCuisine=?";
        if(empty($cuisines)){
            return [];
        }

        // $requete = "$requete";

        for ($i=1; $i < sizeof($cuisines); $i++) { 
            $requete = "$requete OR nomCuisine=?";
        }

        $requete = "$requete GROUP BY osmID ORDER BY nb DESC";

        $reqResto = $bdd->prepare($requete);
        $reqResto->execute($cuisines);
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }

        // A améliorer

        $res = [];
        foreach ($info as $rest) {
            array_push($res, getRestaurantByID($bdd, $rest["osmid"]));
        }

        return $res;
    }

    /**
     * Liste des services proposés 
     * @return string[]
     */
    function getAllServices():array{
        return ["vegetarien","vegan","livraison", "aEmporter", "drive", "accessInternet", "espaceFumeur", "fauteuilRoulant"];
    }

    /**
     * Renvoie une liste de restos possèdant au moins un service
     * @param PDO $bdd
     * @param array $services
     * @return array
     */
    function getRestoByServices(PDO $bdd, array $services):array{
        $requete = "SELECT * FROM RESTAURANT WHERE";
        if(empty($services)){
            return [];
        }

        if (sizeof($services)>=1){
            $requete = "$requete ($services[0] NOTNULL AND $services[0]!='no')";
        }

        for ($i=1; $i < sizeof($services); $i++) { 
            $requete = "$requete OR ($services[$i] NOTNULL AND $services[$i]!='no')";
        }

        $reqResto = $bdd->prepare($requete);
        $reqResto->execute();
        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }
        return $info;
    }

    /**
     * Renvois une liste des commentaires et de la note du restaurant 
     * @param PDO $bdd
     * @param string $osmID
     * @return array liste avec les clefs noteMoy qui donne la note du resto et commentaires avec la liste des commentaires
     */
    function getCommentairesResto(PDO $bdd, string $osmID):array{
        $reqResto = $bdd->prepare("SELECT * FROM AVIS WHERE osmID=?");
        $reqResto->execute(array($osmID));
        $info = $reqResto->fetchAll();

        $res = [];
        $res["noteMoy"] = 0;
        $res["commentaires"] = [];
        if(!$info){
            return $res;
        }
        $res["commentaires"] = $info;

        $note = 0;
        foreach ($info as $comm) {
            if ($comm["note"] != null){
                $note += $comm["note"];
            }
        }

        $res["noteMoy"] = $note/sizeof($info);

        return $res;
    } 

    function estFavoris(PDO $bdd, string $osmID, string $username):bool{
        $requser = $bdd->prepare("SELECT * FROM RESTAURANT_FAVORIS WHERE username=? AND osmID=?");
        $requser->execute(array($username, $osmID));
        $info = $requser->fetch();
        if(!$info){
            return false;
        }
        return true;
    }
?>