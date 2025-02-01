<?php
    require_once __DIR__."/../connexionBD.php";
    require_once __DIR__."/../../annexe/annexe.php";

    /**
     * Renvoie si un nom d'utilisateur est déjà utilisé
     * @param PDO $bdd
     * @param string $username
     * @return bool
     */
    function usernameExist(PDO $bdd, string $username):bool{
        $requser = $bdd->prepare("SELECT * FROM UTILISATEUR WHERE username=?");
        $requser->execute(array($username));
        $info = $requser->fetch();
        if(!$info){
            return false;
        }
        return true;
    }

    /**
     * Renvoie si un utilisateur est administrateur
     * @param PDO $bdd
     * @param string $username
     * @return bool
     */
    function isAdmin(PDO $bdd, string $username):bool{
        $requser = $bdd->prepare("SELECT * FROM UTILISATEUR WHERE username=?");
        $requser->execute(array($username));
        $info = $requser->fetch();
        if(!$info){
            return false;
        }
        return $info["estAdmin"] == true;
    }

    /**
     * Ajoute un utilisateur a la base de donné
     * @param PDO $bdd
     * @param string $username
     * @param string $mdp
     * @param bool $isAdmin
     * @return void si l'utilisateur a pu être ajouté
     */
    function createUser(PDO $bdd, string $username, string $mdp, bool $isAdmin=false):bool{
        if(usernameExist($bdd, $username)){
            return false;
        }
        $mdp = hash('sha256', $mdp);
        $requser = $bdd->prepare("INSERT INTO UTILISATEUR (username,mdp,estAdmin) VALUES (?,?,?)");
        $requser->execute(array($username, $mdp, $isAdmin ? 1 : 0));
        return true;
    }

    /**
     * Renvoie si la connexion est autorisé pour un username et un mdp
     * @param PDO $bdd
     * @param string $username
     * @param string $mdp
     * @return bool
     */
    function canLogin(PDO $bdd, string $username, string $mdp): bool{
        $mdp = hash('sha256', $mdp);
        $requser = $bdd->prepare("SELECT * FROM UTILISATEUR WHERE username=? AND mdp = ?");
        $requser->execute(array($username, $mdp));
        $info = $requser->fetch();
        if(!$info){
            return false;
        }
        return true;
    }

    /**
     * Supprime un utilisateur
     * @param PDO $bdd
     * @param string $username nom d'utilisateur de l'utilisateur a supprimé
     * @return bool si le joueur supprimé existait (A bien été supprimé)
     */
    function deleteUser(PDO $bdd, string $username):bool{
        if(!usernameExist($bdd,$username)){
            return false;
        }
        $requser = $bdd->prepare("DELETE FROM UTILISATEUR WHERE username=?");
        $requser->execute(array($username));
        return true;
    }

    /**
     * Modifie les informations d'un utilisateur
     * @param PDO $bdd
     * @param string $usernameBefore ancien Username
     * @param string $newUsername nouveau Username
     * @param string $mdp nouveau Mdp
     * @param bool $isAdmin
     * @return bool
     */
    function updateUser(PDO $bdd, string $usernameBefore, string $newUsername, string $mdp, bool $isAdmin):bool{
        if($usernameBefore != $newUsername && usernameExist($bdd, $newUsername)){
            return false;
        }
        $mdp = hash('sha256', $mdp);
        $requser = $bdd->prepare("UPDATE UTILISATEUR SET username=?, mdp=?, estAdmin=? WHERE username=?");
        $requser->execute(array($newUsername, $mdp, $isAdmin ? 1 : 0, $usernameBefore));
        return true;
    }
?>