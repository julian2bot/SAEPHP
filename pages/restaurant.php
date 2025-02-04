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



    $avisEtComm = getCommentaireByResto();

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
            <div id='avis' class="avis">
    
                <div class="note-moyenne">
                    <h2><?php echo $avisEtComm["noteMoy"]?></h2>
                    <div class="etoiles"><?php echo formatetoileV2((int)$avisEtComm["noteMoy"]??0)?></div>

                </div>

                <div class="commentaires">
                    <?php
                    if(true): // TODO if(isset($_SESSION["connecte"]))

                    ?>
                    
                        <div class="noter">
                            <form action="" methode="post">
                                
                                <textarea name="avis" placeholder="Laissez votre avis..." cols="100" rows="4" minlength="65" maxlength="500" spellcheck required></textarea>
                                <input type="hidden" name="nbEtoile" value='-1'>
                                <div class="mettreNote">
                                    <p>Ma Note:</p>
                                    <div class="stars">
                                            <a href="#lanote=5" class="star stargrey" ><i data-index="5">★</i></a>
                                            <a href="#lanote=4" class="star stargrey" ><i data-index="4">★</i></a>
                                            <a href="#lanote=3" class="star stargrey" ><i data-index="3">★</i></a>
                                            <a href="#lanote=2" class="star stargrey" ><i data-index="2">★</i></a>
                                            <a href="#lanote=1" class="star stargrey" ><i data-index="1">★</i></a>
                                    </div>   
                                    <button class="publier" type="sumbit">Publier</button>
                                </div>
                            </form>
                        </div>
                    
                    <div class="listComm co">
                        
                    <?php
                    else:
                    ?>
                    <div class="listComm nonCo">
                    
                    <?php
                    endif;
                    
                    ?>
                    <?php
                    foreach($avisEtComm["commentaires"] as $CommUser):
                        // print_r($CommUser); 
                    ?>

                    <div class="commentaire">
                        <h3><?php echo $CommUser["username"]?></h3>
                        <div>

                            <div class="etoiles"><?php echo formatetoileV2((int)$CommUser["note"]??0)?></div>
                            <span class="date"><?php echo $CommUser["datecommentaire"]?></span>
                        </div>                        
                        <div>
                            <?php echo $CommUser["commentaire"]?>
                        </div>
                    </div>
                    <?php
                    endforeach;
                    ?>
                    </div>


<!--                    <div class="commentaire">
                        <h3>JOHNNY SHALLOW</h3>
                        <div>

                            <div class="etoiles">⭐⭐⭐⭐⭐</div>
                            <span class="date">17/02/2077</span>
                        </div>
                        <p>I poured myself a large glass of wine</p>
                    </div>

                    <div class="commentaire">
                        <h3>TIMOTHEE SALAMECHE</h3>
                        <div>

                            <div class="etoiles">⭐⭐⭐⭐⭐</div>
                            <span class="date">17/02/2077</span>
                        </div>
                        <p>Les rêves font de bonnes histoires, mais le chef fait de bons plats</p>
                    </div> -->
                    
                </div>
            </div>




        </div>
    </main>

    
    <script>
        var restaurant = <?php echo json_encode($leresto); ?>;
        initMap(restaurant);

        noteStar(<?php echo 4; ?>)
    </script>
</body>
</html>


