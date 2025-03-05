<?php

require_once "../utils/BD/connexionBD.php";
require_once "../utils/BD/requettes/userManagement.php";


$ancienUsername = $_POST["username"];
$newUsername = $_POST["newusername"];

if($ancienUsername === $newUsername){
    header("Location: ../");
	exit;
}

$user = new User($bdd);




if($user -> updateNameUser($ancienUsername, $newUsername)){
    createPopUp("Votre nom a été modifié avec succès !");
}
else{
    createPopUp("Une erreur s'est produite ! veuillez réessayer ultérieurement", false);
}

header("Location: ../");
exit;