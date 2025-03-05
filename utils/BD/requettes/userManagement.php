<?php
    require_once __DIR__."/../connexionBD.php";
    require_once __DIR__."/../../annexe/annexe.php";

class User{
    protected PDO $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }
    /**
     * Renvoie si un nom d'utilisateur est déjà utilisé
     * @param PDO $bdd
     * @param string $username
     * @return bool
     */
    function usernameExist(string $username):bool{
        $requser = $this->bdd->prepare("SELECT * FROM UTILISATEUR WHERE username=?");
        $requser->execute(array($username));
        $info = $requser->fetch();
        if(!$info){
            return false;
        }
        return true;
    }

    /**
     * Renvoie les infos sur un utilisateur 
     * @param PDO $bdd
     * @param string $username
     * @return bool
     */
    function getUsername(string $username):array{
        $requser = $this->bdd->prepare("SELECT * FROM UTILISATEUR WHERE username=?");
        $requser->execute(array($username));
        $info = $requser->fetch();
        if(!$info){
            return [];
        }
        return $info;
    }

    /**
     * mets les infos sur un utilisateur dans session 
     * @param PDO $bdd
     * @param string $username
     * @return bool
     */
    function userConnecter(string $username):void{
        
        $userinfo = $this->getUsername($username);
        
        $_SESSION["connecte"] = array(
            "username" => $userinfo['username'], 
            "admin" =>  $this-> isAdmin($username) ? "true": "false",
            // "info" => getInfo($username) // je sais pas si on mets ou pas maintenant ?
        );
    }

    /**
     * Renvoie si un utilisateur est administrateur
     * @param PDO $bdd
     * @param string $username
     * @return bool
     */
    function isAdmin(string $username):bool{
        $requser = $this->bdd->prepare("SELECT * FROM UTILISATEUR WHERE username=?");
        $requser->execute(array($username));
        $info = $requser->fetch();
        print_r($info);
        if(!$info){
            return false;
        }
        return $info["estadmin"] == true;
    }

    /**
     * Ajoute un utilisateur a la base de donné
     * @param PDO $bdd
     * @param string $username
     * @param string $mdp
     * @param bool $isAdmin
     * @return void si l'utilisateur a pu être ajouté
     */
    function createUser(string $username, string $mdp, bool $isAdmin=false):bool{
        if($this->usernameExist($username)){
            return false;
        }
        $mdp = hash('sha256', $mdp);
        $requser = $this->bdd->prepare("INSERT INTO UTILISATEUR (username,mdp,estAdmin) VALUES (?,?,?)");
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
    function canLogin(string $username, string $mdp): bool{
        $mdp = hash('sha256', $mdp);
        $requser = $this->bdd->prepare("SELECT * FROM UTILISATEUR WHERE username=? AND mdp = ?");
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
    function deleteUser(string $username):bool{
        if(!usernameExist($bdd,$username)){
            return false;
        }
        $requser = $this->bdd->prepare("DELETE FROM UTILISATEUR WHERE username=?");
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
    function updateUser(string $usernameBefore, string $newUsername, string $mdp, bool $isAdmin):bool{
        // fonction does not exist
        if($usernameBefore != $newUsername && $this->usernameExist($this->bdd, $newUsername)){
            return false;
        }
        $mdp = hash('sha256', $mdp);
        $requser = $this->bdd->prepare("UPDATE UTILISATEUR SET username=?, mdp=?, estAdmin=? WHERE username=?");
        $requser->execute(array($newUsername, $mdp, $isAdmin ? 1 : 0, $usernameBefore));
        return true;
    }

    function updateNameUser(string $usernameBefore, string $newUsername):bool{
        if($usernameBefore != $newUsername && $this->usernameExist($newUsername)){
            return false;
        }
        $requser = $this->bdd->prepare("UPDATE UTILISATEUR SET username=? WHERE username=?");
        $requser->execute(array($newUsername, $usernameBefore));
        $this->userConnecter($newUsername);
        return true;
    }
}


