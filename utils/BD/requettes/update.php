<?php


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