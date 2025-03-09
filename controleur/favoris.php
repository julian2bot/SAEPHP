<?php
if(!session_id()){
    session_start();
    session_regenerate_id(true);
}
require_once '../utils/BD/connexionBD.php';
require_once '../utils/BD/requettes/insert.php';
require_once '../utils/BD/requettes/select.php';

if (!isset($_SESSION["connecte"])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

if (isset($_POST['osmID'])) {
    $osmID = $_POST['osmID'];
    $username = $_SESSION["connecte"]["username"];

    $restaurant = getRestaurantByID($bdd, $osmID);
    // echo json_encode($restaurant);
    if ($restaurant) {
        $result = ajouteRetirerFavoris($bdd, $osmID, $username);
        echo json_encode(['success' => true, 'added' => $result]);
    } else {
        echo json_encode(['error' => 'Restaurant not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
