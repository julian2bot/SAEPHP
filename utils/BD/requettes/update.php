<?php

require_once __DIR__."/select.php";

function addImageRestaurantById(PDO $bdd, string $osmid, string $imageH, string $imageV):bool{
    $requete = "UPDATE RESTAURANT 
    SET horizontal = :imageH, vertical = :imageV
    WHERE osmid = :osmid";

    $stmt = $bdd->prepare($requete);

    $stmt->bindParam(':osmid', $osmid); 
    $stmt->bindParam(':imageH', $imageH); 
    $stmt->bindParam(':imageV', $imageV); 

    if ($stmt->execute()) {
        return true; 
    } else {
        return false; 
    }
}

/**
 * Modifie un commentaire existant
 * @param PDO $bdd
 * @param string $osmid
 * @param string $username
 * @return void
 */
function updateCommentaire(PDO $bdd, string $osmid, string $username, $commentaire, $etoiles):bool{
    $comm = getCommentairesRestoUser($bdd, $osmid, $username);
    if($comm == null){
        return false;
    }
    $reqResto = $bdd->prepare("UPDATE AVIS SET commentaire=?, note=? WHERE osmid=? AND username=?");
    $reqResto->execute(array($commentaire, $etoiles, $osmid, $username));
    return true;
}