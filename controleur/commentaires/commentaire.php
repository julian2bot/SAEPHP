<?php
    require_once __DIR__."/../../utils/BD/connexionBD.php";
    require_once __DIR__."/../../utils/class/commentaire.php";

    echo "<pre>";
    
    print_r($_POST);

    echo "</pre>";

    if(isset($_SESSION["connecte"]["username"])
        && isset($_POST["nbEtoile"])
        && isset($_POST["resto"])
        && isset($_POST["avis"])){
            $comm = new Commentaire($_SESSION["connecte"]["username"],$_POST["nbEtoile"],"",$_POST["resto"],$_POST["avis"]);
            $comm->sendCommentaire($bdd);
        }

    header("Location: ../../pages/restaurant.php?osmID=$_POST[resto]#avis");
	exit;

?>