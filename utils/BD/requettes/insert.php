<?php
    // require_once __DIR__."/../connexionBD.php";
    require_once __DIR__."/../../annexe/annexe.php";
    require_once __DIR__."/select.php";

    /**
     * Créer une région si elle n'existe pas encore
     * @param PDO $bdd
     * @param string $codeRegion id de la région ex 24
     * @param string $nomRegion
     * @return bool true si l'insertion s'est déroullé avec succès
     */
    function createRegion(PDO $bdd, string $codeRegion, string $nomRegion):bool{
        if(! empty(getRegion($bdd, $codeRegion))){
            return false;
        }

        $reqResto = $bdd->prepare("INSERT INTO REGION (coderegion,nomregion) VALUES (?,?)");
        $reqResto->execute(array($codeRegion,$nomRegion));

        return true;
    }

    /**
     * Créer un département si il n'existe pas encore
     * @param PDO $bdd
     * @param string $codeRegion id de la région ex 24
     * @param string $codeDepartement id du département ex 45
     * @param string $nomDepartement
     * @return bool true si l'insertion s'est déroullé avec succès
     */
    function createDepartement(PDO $bdd, string $codeRegion, string $codeDepartement, string $nomDepartement):bool{
        if(! empty(getDepartement($bdd, $codeDepartement))){
            return false;
        }

        $reqResto = $bdd->prepare("INSERT INTO DEPARTEMENT (coderegion,codedepartement,nomdepartement) VALUES (?,?,?)");
        $reqResto->execute(array($codeRegion,$codeDepartement,$nomDepartement));
        return true;
    }

    /**
     * Créer une commune si elle n'existe pas encore
     * @param PDO $bdd
     * @param string $codeDepartement id du département ex 45
     * @param string $codeCommune id de la commune ex 45000
     * @param string $nomCommune
     * @return bool true si l'insertion s'est déroullé avec succès
     */
    function createCommune(PDO $bdd, string $codeDepartement, string $codeCommune, string $nomCommune):bool{
        if(! empty(getCommune($bdd, $codeCommune))){
            return false;
        }

        $reqResto = $bdd->prepare("INSERT INTO COMMUNE (codedepartement,codecommune, nomcommune) VALUES (?,?,?)");
        $reqResto->execute(array($codeDepartement,$codeCommune, $nomCommune));
        return true;
    }

    /**
     * Crée un restaurant a partir d'une liste d'information
     * @param PDO $bdd
     * @param array $info
     * @return bool 
     */
    function createRestaurant(PDO $bdd, array $info) : bool{
        if(sizeof($info)!=24 ||  ! empty(getRestaurantByID($bdd, $info[0]))){
            return false;
        }
        $reqResto = $bdd->prepare("INSERT INTO RESTAURANT VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $reqResto->execute($info);
        return true;
    }

    /**
     * Créer un type de cuisine s'il n'a pas été crée
     * @param PDO $bdd
     * @param string $nomCuisine
     * @return int id de la cuisine crée
     */
    function createCuisine(PDO $bdd, string $nomCuisine):int{
        $idCuisine = getCuisineId($bdd, $nomCuisine);
        if($idCuisine != -1){
            return $idCuisine;
        }
        else{
            $idCuisine = getNextCuisineID($bdd);
        }
        $reqResto = $bdd->prepare("INSERT INTO CUISINE (idcuisine,nomcuisine) VALUES (?,?)");
        $reqResto->execute(array($idCuisine, $nomCuisine));
        return $idCuisine;
    }

    /**
     * Insert une proposition de cuisine pour un restaurant (Crée la cuisine si elle n'existe pas)
     * @param PDO $bdd
     * @param string $osmID
     * @param string $nomCuisine
     * @return bool true si l'insertion s'est déroullé avec succès
     */
    function insertCuisinePropose(PDO $bdd, string $osmID, string $nomCuisine):bool{
        if(in_array($nomCuisine,getCuisinePropose($bdd, $osmID))){
            return false;
        }
        $idCuisine = createCuisine($bdd, $nomCuisine);
        $reqResto = $bdd->prepare("INSERT INTO PROPOSE (idcuisine,osmid) VALUES (?,?)");
        $reqResto->execute(array($idCuisine, $osmID));
        return true;
    }

    /**
     * Insert les horraires d'ouvertures d'un restaurant
     * @param PDO $bdd
     * @param string $osmID
     * @param string $horaires
     * @return bool
     */
    function insertHoraires(PDO $bdd, string $osmID, string $horaires):bool{
        $reqResto = $bdd->prepare("INSERT INTO HEURE_OUVERTURE (osmid,jouroçuverture,heuredebut,heurefin) VALUES (?,?,?,?)");
        foreach (transformOpeningHours($horaires) as $unHorraire) {
            foreach ($unHorraire["jours"] as $unJour) {
                foreach ($unHorraire["heures"] as $unCrenau) {
                    try {
                        $reqResto->execute(array($osmID, $unJour,$unCrenau["debut"], $unCrenau["fin"]));
                    } catch (PDOException $th) {
                        echo "erreur resto : $osmID format : $horaires<br>";
                    }
                }
            }
        }
        return true;
    }

    /**
     * Ajoute un commentaire d'un utilisateur pour un restaurant
     * @param PDO $bdd
     * @param string $osmID
     * @param string $username
     * @param int $note
     * @param string $commentaire
     * @return bool
     */
    function insertCommentaire(PDO $bdd, string $osmID, string $username, int $note, string $commentaire):bool{
        $date = date_format(new DateTime(), "Y-m-d");
        $reqResto = $bdd->prepare("INSERT INTO AVIS (osmid,username,note,commentaire,datecommentaire) VALUES (?,?,?,?,?)");
        try {
            $reqResto->execute(array($osmID,$username,$note,$commentaire,$date));
            return true;
        } catch (PDOException $th) {
            echo "erreur $th";
            return false;
        }
    }

    /**
     * Ajoute ou retire un restaurant aux favoris de l'utilisateur
     * @param PDO $bdd
     * @param string $osmID
     * @param string $username
     * @return bool true si ajout, false sinon
     */
    function ajouteRetirerFavoris(PDO $bdd, string $osmID, string $username):bool{
        // Uncaught PDOException: SQLSTATE[42703]: Undefined column: 7 ERROR:  column "osmidusername" of relation "restaurant_favoris" does not exist
        if(estFavoris($bdd, $osmID, $username)){
            $reqResto = $bdd->prepare("DELETE FROM RESTAURANT_FAVORIS WHERE osmid=? AND username=?");
            $reqResto->execute(array($osmID,$username));
            return false;
        }
        else{
            $reqResto = $bdd->prepare("INSERT INTO RESTAURANT_FAVORIS (osmid, username) VALUES (?,?)");
            $reqResto->execute(array($osmID,$username));
            return true;
        }
    }
?>