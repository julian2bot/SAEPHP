<?php
    require_once "../utils/BD/connexionBD.php";

    require_once "../utils/annexe/getter.php";
    require_once "../utils/BD/requettes/select.php";
    require_once "../utils/annexe/annexe.php";
    require_once "../utils/class/restaurant.php";
    require_once "../utils/class/commentaire.php";

    // echo "<pre>";
    // print_r($_GET);
    // echo "</pre>";

    if (!empty($_GET["osmID"])) {
        $leresto = getRestaurantByID($bdd, $_GET["osmID"]);
    }
    
    if (empty($leresto) && !empty($_GET["resto"])) {
        // $leresto = getRestaurantByName($bdd, $_GET["resto"]);
        header("Location: 404.php");
        exit;
    }
    
    if (empty($leresto)) {
        header("Location: 404.php");
        exit;
    }

    

    // $leresto = getRestaurantByID2();

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

    
    $placeId = getPlaceId($lat, $lon, $leresto["nomrestaurant"], 10);
    $imagesResto = getImageByPlaceId($bdd, $leresto["osmid"], $placeId);
    // echo "<pre>";
    // print_r($imagesResto);
    // echo "</pre>";
    // echo "<img src=\"".$imagesResto["vertical"][0]."\" alt=''>";

    // echo "<img src=\"".$imagesResto["horizontal"][0]."\" alt=''>";
    
    // print_r(getimagesize($imagesResto["photos"][0]))  ;
    
    
    // $avisEtComm = getCommentaireByResto2();
    $avisEtComm = getCommentairesResto($bdd, $leresto["osmid"]);
    // echo "<pre>";
    // print_r($avisEtComm);
    // echo "</pre>";



    $restoClass = new Restaurant(
        $leresto["osmid"],
        $leresto["nomrestaurant"],
        $leresto["etoiles"],
        $leresto["codecommune"]??'',
        $leresto["nomcommune"]??'',
        $leresto["cuisines"],
        $leresto["telephone"]??null,
        $leresto["siteinternet"]??null,
        $imagesResto["vertical"]??null,
        $imagesResto["horizontal"]??null,
        $avisEtComm["noteMoy"]??null,
    );
    $comm = isset($_SESSION["connecte"]) ? getCommentairesRestoUser($bdd, $_GET["osmID"], $_SESSION["connecte"]["username"]) : null;
    print_r($comm);

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
    <script src="../assets/script/deleteComm.js"></script>
    <script src="../assets/script/popUpGestionErr.js"></script>
</head>
<body>
    <?php
        require "../assets/affichage/header.php";
    ?>
    
    <section class="fond">
        <div>
            <H1><?php echo $restoClass-> getNom()??"Pas de restaurant trouvé"?></H1>
            <p class="note"><?php echo $restoClass-> formatetoile()?></p>
        </div>

    </section>

    <main class="grid-container">
        <div class="container">
            <div class="adresse">
                <a href="<?php echo lienItineraire($lat, $lon);?>">
                    <?php echo $restoClass-> formatAdresse($dataResto)??"Pas d'adresse trouvé" ?>

                </a>
            </div>
            <div class="type"> 
                <?php
                    echo $restoClass-> formatCuisine();       
                ?>
            </div>
            <div class="img">
                <!-- <img src="../assets/img/Boeuf.png" alt="resto:"> -->
                <img src="<?php echo $restoClass->getImageHorizontal()??"../assets/img/Boeuf.png"?>" alt="resto:">

            </div>
            <div class="img2">
                <img src="<?php echo $restoClass->getImageVertical()??"../assets/img/Jarret.png"?>" alt="resto:">
                <!-- <img src="../assets/img/Jarret.png" alt="resto:"> -->
            </div>
            <div class="numtel">
                <a href="tel:+<?php echo $restoClass->getTelephone()?>"><?php echo $restoClass->getTelephone()??"pas de téléphone"?></a>
            </div>
            <div class="siteweb">
                <a href="<?php echo $restoClass->getSite()??"#"?>">SiteWeb</a>     
                
            </div>
            <div class="jsp"> </div>
            <div class="jsp2"> </div>
            <div id="map" class="map">

            </div>




<!-- a faire plus tard -->





            <div id='avis' class="avis">
    
                <div class="note-moyenne">
                    <h2><?php $restoClass-> getNoteMoyenne()?></h2>
                    <div class="etoiles"><?php echo formatetoileV2((int)$avisEtComm["noteMoy"]??0)?></div>

                </div>

                <div class="commentaires">
                    <?php
                    // if(true): // todo login 
                    if(isset($_SESSION["connecte"])):

                        if($comm == null):
                    ?>
                    
                        <div class="noter">
                            <form action="../controleur/commentaires/commentaire.php" method="POST">
                                
                                <textarea name="avis" placeholder="Laissez votre avis..." cols="100" rows="4" minlength="5" maxlength="500" spellcheck required></textarea>
                                <input type="hidden" name="nbEtoile" value='-1'>
                                <input type="hidden" name="resto" value="<?php echo $_GET["osmID"]?>">
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

                    <?php
                        else:
                    ?>
                        <div class="noter">
                            <form action="../controleur/commentaires/commentaire.php" method="POST">
                                
                                <textarea name="avis" placeholder="Laissez votre avis..." cols="100" rows="4" minlength="5" maxlength="500" spellcheck required><?php echo $comm["commentaire"]?></textarea>
                                <input type="hidden" name="nbEtoile" value='-1'>
                                <input type="hidden" name="resto" value="<?php echo $_GET["osmID"]?>">
                                <div class="mettreNote">
                                    <p>Ma Note:</p>
                                    <div class="stars">
                                            <a href="#lanote=5" class="star stargrey" ><i data-index="5">★</i></a>
                                            <a href="#lanote=4" class="star stargrey" ><i data-index="4">★</i></a>
                                            <a href="#lanote=3" class="star stargrey" ><i data-index="3">★</i></a>
                                            <a href="#lanote=2" class="star stargrey" ><i data-index="2">★</i></a>
                                            <a href="#lanote=1" class="star stargrey" ><i data-index="1">★</i></a>
                                    </div>   
                                    <button class="publier" type="sumbit">Modifier</button>
                                </div>
                            </form>
                            <form action="../controleur/commentaires/commentaireSuppression.php" method="POST">
                                <input type="hidden" name="resto" value="<?php echo $_GET["osmID"]?>">
                                <button class="publier" type="sumbit">Supprimer</button>
                            </form>
                        </div>
                    <?php
                    endif;
                    
                    ?>
                    
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
                        if (isset($_SESSION["connecte"]["username"]) && $_SESSION["connecte"]["username"] != $CommUser["username"]){
                            $commentaireClass = new Commentaire(
                                $CommUser["username"],
                                $CommUser["note"]??0,
                                $CommUser["datecommentaire"],
                                $_GET["osmID"],
                                $CommUser["commentaire"]
                            )  ;
                            $commentaireClass->renderCommentaire();
                        }
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

        noteStar(<?php echo $comm["note"] ?? 2; ?>) // todo get la note du client pour se resto et le mettre a la place du 4
    </script>
</body>
</html>


