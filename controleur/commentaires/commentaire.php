<?php
if(!session_id()){
    session_start();
    session_regenerate_id(true);
}
    require_once __DIR__."/../../utils/BD/connexionBD.php";
    require_once __DIR__."/../../utils/class/AutoLoad.php" ;
    use utils\class\Commentaire as Commentaire;

    if(isset($_SESSION["connecte"]["username"])
        && isset($_POST["nbEtoile"])
        && isset($_POST["resto"])
        && isset($_POST["avis"])){
            $comm = new Commentaire($_SESSION["connecte"]["username"],$_POST["nbEtoile"],"",$_POST["resto"],$_POST["avis"]);
            $res = $comm->sendCommentaire($bdd);
            createPopUp("Commentaire ".($res?"modifié":"ajouté")." avec succès !");
        }

    header("Location: ../../pages/restaurant.php?osmID=$_POST[resto]#avis");
	exit;

?>