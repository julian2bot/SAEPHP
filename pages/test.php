<?php

    require_once "../utils/BD/connexionBD.php";
    // $bdd = new PDO('mysql:host=localhost;dbname=saeponey', "root", "marques");

    require_once "../utils/annexe/getter.php";
    require_once "../utils/BD/requettes/select.php";
    require_once "../utils/annexe/annexe.php";
    require_once "../utils/BD/requettes/userManagement.php";

    // echo "<pre>";

        
$user = new User($bdd);

echo $user -> updateNameUser("jus", "julian") ? "true ok" : "false fail gross nulll"

// $resto = getMesRecommandations($bdd, "visiteur"); // todo login changé visiteur par $_SESSION["connecte"]["username"]

// echo "<pre>";
// print_r($resto);
// echo "</pre>";

// function rechercheResto(PDO $bdd, string $value):array{

	
// 	$cuis = getRestoByCuisine($bdd, array($value));
// 	$resto = getRestaurantByName($bdd, $value);
	
// 	// print_r($cuis);
// 	// print_r($resto);

//     // echo "melange";
//     return array_merge($cuis, $resto);

// }

// echo "<pre>";
// print_r(rechercheResto($bdd, "ita"));
// echo "</pre>";
// $resto = getRestaurantByName($bdd,"O'Tacos");
// print_r($resto);


?>