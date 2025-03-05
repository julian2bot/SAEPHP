<?php
    require_once __DIR__."/../utils/BD/connexionBD.php";
    require_once __DIR__."/../utils/class/commentaire.php";

    echo "<pre>";
    
    print_r($_POST);

    echo "</pre>";

    if(isset($_SESSION["connecte"]["username"])
        && isset($_POST["resto"])){
            $comm = new Commentaire($_SESSION["connecte"]["username"],0,"",$_POST["resto"],"");
            $comm->deleteCommentaire($bdd);
        }

    header("Location: ../pages/restaurant.php?osmID=$_POST[resto]#avis");
	exit;

?>