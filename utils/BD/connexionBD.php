<?php
// base de base

session_start();

// pass.csv DANS /utils/BD/pass.csv
// $passCsv = fopen( __DIR__ . '/passLocal.csv', 'r');
$passCsv = fopen( __DIR__ . '/pass.csv', 'r');
if (!feof($passCsv)) {
    $replace = [";","\n","\r","\r\n"];
    $host = str_replace($replace,"",fgets($passCsv)) ;
    $user = str_replace($replace,"",fgets($passCsv)) ;
    $dbname = str_replace($replace,"",fgets($passCsv)) ;
    $port = str_replace($replace,"",fgets($passCsv)) ;
    $mdp = str_replace($replace,"",fgets($passCsv)) ;
}

$bdd = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $mdp);
// $bdd = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $mdp);
// version en local pour des tests

?>