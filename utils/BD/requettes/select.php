<?php
    // require_once __DIR__."/../connexionBD.php";

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
     * Renvois tous les restos
     * @param PDO $bdd
     * @return array
     */
    function getResto(PDO $bdd):array{
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT");
        $reqResto->execute(array());

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
     * Renvoie les informations d'un restaurant
     * @param PDO $bdd
     * @param string $name
     * @return array informations du restaurant ou liste vide s'il n'existe pas
     */
    function getRestaurantByName(PDO $bdd, string $name):array{
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT WHERE nomrestaurant = ?");
        $reqResto->execute(array("%$name%"));

        $info = $reqResto->fetchAll();
        if(!$info){
            return [];
        }
        for ($i=0; $i < sizeof($info); $i++) { 
            $info[$i]["cuisines"] = getCuisinePropose($bdd,$info[$i]["osmid"]);
        }
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
     * @param array $types
     * @return array
     */
    function getRestoByType(PDO $bdd, array $types):array{
        $requete = "SELECT * FROM RESTAURANT WHERE type LIKE ?";

        if(empty($types)){
            return [];
        }

        for ($i=1; $i < sizeof($types); $i++) { 
            $requete = "$requete OR type LIKE ?";
        }

        for ($i=0; $i < sizeof($types); $i++) { 
            $types[$i] = "%$types[$i]%";
        }

        $reqResto = $bdd->prepare($requete);
        $reqResto->execute($types);
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
        $reqResto = $bdd->prepare("SELECT * FROM RESTAURANT WHERE marque LIKE ?");
        $reqResto->execute(array("%$marque%"));
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
        $requete = "SELECT DISTINCT osmID, count(osmID) as nb FROM PROPOSE NATURAL JOIN CUISINE WHERE nomCuisine LIKE ?";
        if(empty($cuisines)){
            return [];
        }

        // $requete = "$requete";

        for ($i=1; $i < sizeof($cuisines); $i++) { 
            $requete = "$requete OR nomCuisine LIKE ?";
        }

        for ($i=0; $i < sizeof($cuisines); $i++) { 
            $cuisines[$i] = "%$cuisines[$i]%";
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

    /**
     * Renvois la liste des favoris de l'utilisateur
     * @param PDO $bdd
     * @param string $username
     * @return array
     */
    function getLesFavoris(PDO $bdd, string $username):array{
        $requser = $bdd->prepare("SELECT * FROM RESTAURANT_FAVORIS NATURAL JOIN RESTAURANT WHERE username=?");
        $requser->execute(array($username));
        $info = $requser->fetchAll();
        if(!$info){
            return [];
        }
        return $info;
    }

    /**
     * Renvoie si le resto est dans les favoris de l'utilisateur
     * @param PDO $bdd
     * @param string $osmID
     * @param string $username
     * @return bool
     */
    function estFavoris(PDO $bdd, string $osmID, string $username):bool{
        $requser = $bdd->prepare("SELECT * FROM RESTAURANT_FAVORIS WHERE username=? AND osmID=?");
        $requser->execute(array($username, $osmID));
        $info = $requser->fetch();
        if(!$info){
            return false;
        }
        return true;
    }

    /**
     * Liste des avis écrits par un utilisateur
     * @param PDO $bdd
     * @param string $username
     * @return array
     */
    function getMesAvis(PDO $bdd, string $username):array{
        $reqResto = $bdd->prepare("SELECT * FROM AVIS NATURAL JOIN RESTAURANT WHERE username=?");
        $reqResto->execute(array($username));
        $info = $reqResto->fetchAll();

        if(!$info){
            return [];
        }
        return $info;
    }

    /**
     * Fonctions renvoyant une liste de recommandations de restaurants en fonctions des restaurants favoris et des avis de l'utilisateurs
     * @param PDO $bdd
     * @param string $username
     * @param int $max Nombre de reco max
     * @return array
     */
    function getMesRecommandations(PDO $bdd, string $username, int $max=10):array{
        $favoris = getLesFavoris($bdd, $username);
        $reqResto = $bdd->prepare("SELECT * FROM AVIS NATURAL JOIN RESTAURANT WHERE username=? AND note>=3");
        $reqResto->execute(array($username));
        $meilleurs = $reqResto->fetchAll();

        $avis = getMesAvis($bdd,$username);

        if(!$meilleurs){
            $meilleurs = [];
        }

        $lesCuisines = [];
        $lesTypes = [];
        
        foreach ($favoris as $favResto) {
            // Types
            if(!isset($lesTypes[$favResto["type"]])){
                $lesTypes[$favResto["type"]] = 0;
            }
            $lesTypes[$favResto["type"]] += 1;
            // Cuisines
            foreach (getCuisinePropose($bdd,$favResto["osmid"]) as $cuisine) {
                if(!isset($lesCuisines[$cuisine])){
                    $lesCuisines[$cuisine] = 0;
                }
                $lesCuisines[$cuisine] += 1;
            }
        }

        foreach ($meilleurs as $favResto) {
            // Types
            if(!isset($lesTypes[$favResto["type"]])){
                $lesTypes[$favResto["type"]] = 0;
            }
            $lesTypes[$favResto["type"]] += 1;
            // Cuisines
            foreach (getCuisinePropose($bdd,$favResto["osmid"]) as $cuisine) {
                if(!isset($lesCuisines[$cuisine])){
                    $lesCuisines[$cuisine] = 0;
                }
                $lesCuisines[$cuisine] += 1;
            }
        }

        arsort($lesCuisines);
        arsort($lesTypes);

        // Réduires aux 2 critères max

        $lesCuisines = array_slice($lesCuisines,0,2);
        $lesTypes = array_slice($lesTypes,0,2);

        $lesCuisines = getRestoByCuisine($bdd, array_keys($lesCuisines));
        $lesTypes = getRestoByType($bdd, array_keys($lesTypes));


        $lesRecos = [];

        // Ajouter les recos si le resto n'est pas dans les avis ou dans les favoris et que la liste des recos n'a pas atteint le nombre max

        $indexCuisines = 0;
        $indexTypes = 0;

        while($indexCuisines<$max && $indexCuisines < sizeof($lesCuisines) && sizeof($lesRecos)<$max){
            if(! in_array($lesCuisines[$indexCuisines],$avis) && ! in_array($lesCuisines[$indexCuisines],$favoris)  && ! in_array($lesCuisines[$indexCuisines],$lesRecos)){
                array_push($lesRecos, $lesCuisines[$indexCuisines]);
            }

            $indexCuisines++;
        }

        while($indexTypes<$max && $indexTypes < sizeof($lesTypes) && sizeof($lesRecos)<$max){
            if(! in_array($lesTypes[$indexTypes],$avis) && ! in_array($lesTypes[$indexTypes],$favoris)  && ! in_array($lesTypes[$indexTypes],$lesRecos)){
                array_push($lesRecos, $lesTypes[$indexTypes]);
            }

            $indexTypes++;
        }

        // Si la liste n'est pas remplis, la remplir avec des restos l'embdas
        
        if(sizeof($lesRecos)<$max){
            $indexLambda = 0;
            $lesRestosLamba = getResto($bdd);
            while($indexLambda<$max && $indexLambda < sizeof($lesRestosLamba) && sizeof($lesRecos)<$max){
                if(! in_array($lesRestosLamba[$indexLambda],$avis) && ! in_array($lesRestosLamba[$indexLambda],$favoris)  && ! in_array($lesRestosLamba[$indexLambda],$lesRecos)){
                    array_push($lesRecos, $lesRestosLamba[$indexLambda]);
                }
                $indexLambda++;
            }
        }

        // Ajouter la liste des cuisines des restos si elle n'est pas déjà mise

        for ($i=0; $i < sizeof($lesRecos); $i++) { 
            if(!isset($lesRecos[$i]["cuisines"])){
                $lesRecos[$i]["cuisines"] = getCuisinePropose($bdd, $lesRecos[$i]["osmid"]);
            }
        }

        return $lesRecos;
    }
?>