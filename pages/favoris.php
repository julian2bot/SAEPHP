<?php
    require_once "../utils/BD/connexionBD.php";
    // $bdd = new PDO('mysql:host=localhost;dbname=saeponey', "root", "marques");

    require_once "../utils/annexe/getter.php";
    require_once "../utils/BD/requettes/select.php";
    require_once "../utils/annexe/annexe.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=4, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/style/reset.css">
    <link rel="stylesheet" href="../assets/style/all.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/favoris.css">
</head>
<body>
    <?php
        require "../assets/affichage/header.php";
    ?>

    <main>
    <h1>Favoris <span class="hearts"> &#10084 </span></h1>
    <div class="lesFavoris">

        <?php 
       $resto = getMesRecommandations($bdd, $_SESSION["connecte"]["username"]); // todo login changé visiteur par $_SESSION["connecte"]["username"]
       
        //   echo "<pre>";
        //   print_r($resto[0]);
        //   echo "</pre>";
       
       
       $limite = 5;
       $cpt=0;
       foreach($resto as $value):
        if($cpt >= $limite){
            break;
        }
        $cpt++;
        //    echo "<pre>";
        //    print_r($value);
        //    echo "</pre>";
        
        ?>
        <div class="recommendationResto">
            <span class="hearts positionHeart"> &#10084 </span>
            <img src="../assets/img/backgroundImage2.png" alt="resto:">
            
            <div class="nomnote">
                <p class="soustitre"><?php echo $value["nomrestaurant"]?></p>  
                <div class="note"><?php echo formatetoile($value["etoiles"]??0)?></div>
            </div>
            <div class="adresse">
                <p><?php echo formatAdresseCommune($value)?></p>
            </div>
            <div class="attr">
                <p>🍽</p>
                <p>
                    <?php
                            echo formatCuisine($value)
                            ?>
                    </p>
                </div>
                
                <p><a href="<?php echo formatUrlResto($value["osmid"],$value["nomrestaurant"]);?>" style="text-decoration:none; color:black;">Voir plus</a></p>
            </div>
            <?php  endforeach; ?> 
            
            
        </div>
    </div>
    </main>


</body>
</html>