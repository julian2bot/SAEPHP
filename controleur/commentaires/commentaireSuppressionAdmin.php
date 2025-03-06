<?php
    require_once __DIR__."/../../utils/BD/connexionBD.php";
    // require_once __DIR__."/../../utils/class/commentaire.php";
    require_once __DIR__."/../../utils/class/AutoLoad.php" ;
    use utils\class\Commentaire as Commentaire;


    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header("Content-Type: application/json");



    if(isset($_SESSION["connecte"]["admin"])
        && $_SESSION["connecte"]["admin"] == "true"
        && isset($_POST["username"])
        && isset($_POST["osmID"])){
            $comm = new Commentaire($_POST["username"],0,"",$_POST["osmID"],"");

            try {
                $comm->deleteCommentaire($bdd);
                $response = ["success" => true, "message" => "Commentaire supprimé avec succès !"];
            } catch (Exception $e) {
                $response = ["success" => false, "message" => "Erreur : " . $e->getMessage()];
            }
        }
    else{
        $response = ["success" => false, "message" => "Erreur : Permission non authorisé"];
    }

    echo json_encode($response);
?>