<?php
// if(false): //  todo login 
if(!isset($_SESSION)){
    session_start();
}


if(!isset($_SESSION["connecte"])):
?>

<header>
    <nav>
        <ul>
            <li class="titre"><a href="../../">IUTABLES'O</a></li>
            <li class="centerHaut"><a href="../pages/login.php">SE CONNECTER</a></li>
        </ul>
    </nav>
</header>

<?php
else:
?>

<header>
    <nav>
        <ul>
            <li class="titre"><a href="../../">IUTABLES'O</a></li>
            <div style="display:flex; gap:20px;">

                <li class="centerHaut"><a href="../pages/favoris.php">Vos favoris</a></li>
                <li class="centerHaut"><a href="#">Profile</a></li>
            </div>
        </ul>
    </nav>
</header>

<?php
endif;
require_once __DIR__."/../../utils/annexe/annexe.php";
affichePopUp();
?>

