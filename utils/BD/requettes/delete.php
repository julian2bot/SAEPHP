<?php
    require_once __DIR__."/select.php";

    /**
     * Supprime un commentaire d'un utilisateur sur un resto
     * @param PDO $bdd
     * @param string $osmID
     * @param string $username
     * @return bool si le commentaire a pu être supprimé
     */
    function deleteCommentaireUser(PDO $bdd, string $osmID, string $username):bool{
        $comm = getCommentairesRestoUser($bdd, $osmID, $username);
        if($comm == null){
            return false;
        }
        $reqResto = $bdd->prepare("DELETE FROM AVIS WHERE osmid=? AND username=?");
        $reqResto->execute(array($osmID, $username));
        return true;
    }
?>