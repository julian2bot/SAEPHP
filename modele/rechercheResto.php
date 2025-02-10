<?php
require_once "../utils/BD/connexionBD.php";
require_once "../utils/BD/requettes/select.php";


if(isset($_POST["nomRestoCuisine"])){
    // echo $_POST["nomRestoCuisine"];
    echo json_encode(rechercheResto($bdd, $_POST["nomRestoCuisine"]));
}
else{
    echo json_encode(array());
}