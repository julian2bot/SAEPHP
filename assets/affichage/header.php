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
                <li class="centerHaut"><a id="openProfil" href="#">Profile</a></li>
            </div>
        </ul>
    </nav>
</header>
<div style="display:none;" id="profile">
    <div class="dflex" style="justify-content:space-around;">
        <img src="/assets/img/avatar.png" alt="logoProfile">
        <p><?php echo $_SESSION["connecte"]["username"]?></p>
        <img src="/assets/img/edit.png" alt="logoProfile" id="openProfileEdit">
    </div>
    <div style="display:none;" id="profileEdit">
        
        <form action="/controleur/updateUser.php" method="post">
            <input name="username" type="hidden" value="<?php echo $_SESSION["connecte"]["username"]?>">
            <div class="dflexCol">

                <label for="newusername">Nouveau nom
                    
                    <input name="newusername" type="text" value="<?php echo $_SESSION["connecte"]["username"]?>">
                </label>    
            </div>
            
            <div class="dflex">

                <input name="editProfileButton" type="submit">
                <button id="closeProfileEdit">Annuler</button>
            </div>
        </form>        
    </div>
    <div class="dflex" style="justify-content:space-around;">
        <a href="/controleur/logout.php" class="deco">Se Deconnecter</a>
        <button id="closeProfile">Fermer</button>

    </div>
</div>

<script src="../assets/script/header.js"></script>
<?php
endif;
require_once __DIR__."/../../utils/annexe/annexe.php";
affichePopUp();
?>

