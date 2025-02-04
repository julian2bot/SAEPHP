<?php

    require_once "../utils/BD/connexionBD.php";
    // $bdd = new PDO('mysql:host=localhost;dbname=saeponey', "root", "marques");

    require_once "../utils/annexe/getter.php";
    require_once "../utils/BD/requettes/select.php";
    require_once "../utils/annexe/annexe.php";

    // echo "<pre>";


$resto = getMesRecommandations($bdd, "visiteur"); // todo login changé visiteur par $_SESSION["connecte"]["username"]

echo "<pre>";
print_r($resto);
echo "</pre>";



?>