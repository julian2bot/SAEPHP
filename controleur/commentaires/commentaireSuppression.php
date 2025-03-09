<?php
if(!session_id()){
    session_start();
    session_regenerate_id(true);
}
    require_once __DIR__."/../../utils/BD/connexionBD.php";
    // require_once __DIR__."/../../utils/class/commentaire.php";
    require_once __DIR__."/../../utils/class/AutoLoad.php" ;
    use utils\class\Commentaire as Commentaire;

    if(isset($_SESSION["connecte"]["username"])
        && isset($_POST["resto"])){
            $comm = new Commentaire($_SESSION["connecte"]["username"],0,"",$_POST["resto"],"");
            $comm->deleteCommentaire($bdd);
            createPopUp("Commentaire suprimé avec succès !");
        }

    header("Location: ../../pages/restaurant.php?osmID=$_POST[resto]#avis");
	exit;

?>