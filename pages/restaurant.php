<?php
    // require_once "../utils/BD/connexionBD.php";
    $bdd = new PDO('mysql:host=localhost;dbname=saeponey', "root", "marques");

    require_once "../utils/annexe/getter.php";
    require_once "../utils/annexe/annexe.php";

    $leresto = getRestaurantByID();

    // echo "<pre>";
    // print_r($leresto);
    // echo "</pre>";


    $lat = $leresto["latitude"];
    $lon = $leresto["longitude"];

    $dataResto = getRestaurantInfoByCo($lat, $lon);

    // getImageRestoByCo($lat, $lon);
    // echo "<pre>";
    // print_r($dataResto);
    // echo "</pre>";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />

    <title>Restaurant Le HDC</title> 
    <link rel="stylesheet" href="../assets/style/reset.css">
    <link rel="stylesheet" href="../assets/style/all.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/restaurant.css">
    <script src="../assets/script/restaurant.js"></script>
</head>
<body>
    <?php
        require "../assets/affichage/header.php";
    ?>
    
    <section class="fond">
        <div>
            <H1><?php echo $leresto["nomrestaurant"]??"Pas de restaurant trouvé"?></H1>
            <p class="note"><?php echo formatetoile($leresto["etoiles"]??0)?></p>
        </div>

    </section>

    <main class="grid-container">
        <div class="container">
            <div class="adresse">
                <a href="<?php echo lienItineraire($lat, $lon);?>">
                    <?php echo formatAdresse($dataResto)??"Pas d'adresse trouvé" ?>

                </a>
            </div>
            <div class="type"> 
                <?php
                    echo formatCuisine($leresto);       
                ?>
            </div>
            <div class="img">
                <img src="../assets/img/Boeuf.png" alt="resto:">

            </div>
            <div class="img2">
                <img src="../assets/img/Jarret.png" alt="resto:">
            </div>
            <div class="numtel">
                <?php echo $leresto["telephone"]?>
            </div>
            <div class="siteweb">
                <a href="<?php echo $leresto["siteinternet"] ?>">SiteWeb</a>        
                
            </div>
            <div class="jsp"> </div>
            <div class="jsp2"> </div>
            <div id="map" class="map">

            </div>
            <div class="avis">rien</div>
        </div>
    </main>

    
    <script>
        var restaurant = <?php echo json_encode($leresto); ?>;
        initMap(restaurant);
    </script>
</body>
</html>
