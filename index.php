<?php
    require_once "utils/BD/connexionBD.php";
    // $bdd = new PDO('mysql:host=localhost;dbname=saeponey', "root", "marques");

    require_once "utils/annexe/getter.php";
    require_once "utils/BD/requettes/select.php";
    require_once "utils/annexe/annexe.php";
    require_once "utils/class/restaurant.php";
    // print_r($_SESSION);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=4, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/style/reset.css">
    <link rel="stylesheet" href="assets/style/all.css">
    <link rel="stylesheet" href="assets/style/header.css">
    <link rel="stylesheet" href="assets/style/style.css">
    <script type="module" src="assets/script/rechercheResto.js"></script>
</head>
<body>
    <?php
    require "assets/affichage/header.php";
    ?>

    <main>
        <!-- img background image -->
        <div id="recherche">
            <!-- <form  action="" method="post">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg_icon bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path></svg>
                <input class="input" type="text" name="donnee" id="donne">
            </form> -->


            <!-- <form action="modeleTemp/rechercheResto.php" method="post" class="custom_input"> -->
            <form action="" method="post" class="custom_input">
                <button class="svg_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg_icon bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path></svg>
                </button>
                <input class="input" list="liste-restaurant"  type="text" placeholder="Recherche restaurant, ville..." name="donnee" id="donne">


                <datalist id="liste-restaurant">
                </datalist> 

                
            </form>
        </div>


        <div id="resultat">

            <!-- boucle php pour mettre les resultats -->
            <!-- nom etoile + note
            code postale + ville
            img logo + type bouffe (a)

            separation entre chaque -->


        <?php
            // if(isset($_GET["donnee"])){
            $resto = getMesRecommandations($bdd, $_SESSION["connecte"]["username"]??""); // todo login changé admin par $_SESSION["connecte"]["username"] et changé le favorie en se qu'il faut apres ? (quand on fait une recherche)

            // }else{
            //     $resto = getMesRecommandations($bdd, "admin"); // todo login changé admin par $_SESSION["connecte"]["username"] et changé le favorie en se qu'il faut apres ? (quand on fait une recherche)
            // }
            // dans annexe:
        // echo "<pre>";
        // print_r($resto);
        // echo "</pre>";


        foreach($resto as $value):
            $restoClass = new Restaurant($value["osmid"],$value["nomrestaurant"],$value["etoiles"],$value["codecommune"]??'',$value["nomcommune"]??'',$value["cuisines"]);

            // echo $restoClass ->getNom(); 
            $restoClass-> renderIndexLesRestosRecherche();
        
        endforeach;
        ?>
        
        </div>
        
    </main>


    <section id="recommendation">
        <h1>Nos recommandations</h1>
        <div id="recommendationRestoContainer">

       <?php 
       $resto = getMesRecommandations($bdd, $_SESSION["connecte"]["username"]??""); // todo OK? login changé visiteur par $_SESSION["connecte"]["username"]
       
    //    echo "<pre>";
    //    print_r($resto[0]);
    //    echo "</pre>";


    $limite = 3;
    $cpt=0;
    foreach($resto as $value):
        if($cpt >= $limite){
            break;
        }
        $cpt++;

        $restoClass = new Restaurant($value["osmid"],$value["nomrestaurant"],$value["etoiles"],$value["codecommune"]??'',$value["nomcommune"]??'',$value["cuisines"]);

        //    echo "<pre>";
        //    print_r($value);
        //    echo "</pre>";
        $restoClass-> renderIndexLesRecommandations();
    
    endforeach;
    ?>
    
          

        </div>
    </section>

</body>
</html>