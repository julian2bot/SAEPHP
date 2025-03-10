<?php
    require_once __DIR__."/jsonToBD.php";
    require_once __DIR__."/../BD/connexionBD.php";
    
    addAllRestoFromJson($bdd,$lesRestaurants);
?>