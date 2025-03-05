<?php
require_once "../utils/BD/connexionBD.php";
// $bdd = new PDO('mysql:host=localhost;dbname=saeponey', "root", "marques");

require_once "../utils/annexe/getter.php";
require_once "../utils/BD/requettes/select.php";
require_once "../utils/annexe/annexe.php";
require_once "../utils/class/restaurant.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=4, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/style/reset.css">
    <link rel="stylesheet" href="../assets/style/all.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/favoris.css">
    <script src="../assets/script/favoris.js"></script>
</head>
<body>
    <?php
    require "../assets/affichage/header.php";
    ?>

    <main>
        <h1>Favoris <span class="hearts"> &#10084 </span></h1>
        <h2>Restaurants Recommandés</h2>
        <div class="lesFavoris">
            <?php
            //    todo chnager reco en fav lool
            $resto = getMesRecommandations($bdd, $_SESSION["connecte"]["username"]) ?? []; // todo login changé visiteur par $_SESSION["connecte"]["username"]

            //   echo "<pre>";
            //   print_r($resto[0]);
            //   echo "</pre>";
            

            $limite = 5;
            $cpt=0;
            foreach($resto as $value):
                // limite si over ou under
                if ($cpt >= $limite || $cpt >= count($resto)) {
                    break;
                }
                $cpt++;
                $restoClass = new Restaurant($value["osmid"],$value["nomrestaurant"],$value["etoiles"],$value["codecommune"]??'',$value["nomcommune"]??'',$value["cuisines"] ?? '');

                //    echo "<pre>";
                //    print_r($value);
                //    echo "</pre>";
            
                $restoClass->renderFavoris($bdd);

            endforeach;
            ?>



        </div>
        <h2>Restaurants Favoris</h2>
        <div class="lesFavoris">
            <?php
            $favoris = getLesFavoris($bdd, $_SESSION["connecte"]["username"]) ?? []; // todo login changé visiteur par $_SESSION["connecte"]["username"]
            foreach ($favoris as $value):
                // echo "<pre>";
                // print_r($value);
                //echo "</pre>";
                $restoClass = new Restaurant($value["osmid"], $value["nomrestaurant"], $value["etoiles"] ?? 0, $value["codecommune"] ?? '', $value["nomcommune"] ?? '', $value["cuisines"] ?? []);
                $restoClass->renderFavoris($bdd);
            endforeach;
            ?>
        </div>
    </main>


</body>
</html>