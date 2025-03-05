<?php
require_once '../util/class/user.php';

if (isset($_POST['osmID']) && isset($_POST['state'])) {
    $osmID = $_POST['osmID'];
    $state = $_POST['state'];

    $user = $_SESSION["connecte"]["username"]; // todo grab avec la class user

    if ($state === 'hearts') {
        $result = $user->mettre_en_fav($osmID);
    } else {
        $result = $user->enlever_fav($osmID);
    }

    echo json_encode(['success' => $result]);
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
