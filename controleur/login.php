<?php
require_once "../utils/BD/connexionBD.php";
require_once "../utils/BD/requettes/select.php";
require_once "../utils/BD/requettes/userManagement.php";
require_once __DIR__."/../utils/annexe/annexe.php";

// code pour se login verifier s'il est bien dans la BD et mettre toute les valeurs dans le $_SESSION

if(isset($_POST['formLogin'])){
	$username = htmlspecialchars($_POST['username']);
	// $pass2 = /*password_hash*/sha1($_POST['PassWordLogin']/*, PASSWORD_DEFAULT*/);
    $mdp = hash('sha256', $_POST['password']);
	
	if(!empty($_POST['username']) AND !empty($_POST['password'])){
        // echo "username et password ok";
		// echo $_POST['username']." " .$_POST['password'];

        
        $user = new User($bdd);
        if($user ->canLogin($username, $mdp)){
            // echo "utilisateur connu";
            $user ->userConnecter($username);
        }else{	
            // echo "utilisateur inconnu";
			$erreur = $user->usernameExist($_POST['username']) ? "Mot de passe incorrect !" : "Cette utilisateur n'est pas connu !";
        }   
    }   
        
	else{
		$erreur =  "Tous les champs doivent être complétés !";
	}
}

// retourne sur la page index avec l'erreur s'il y en a une 
if($erreur){
    createPopUp($erreur, false);
	header("Location: ../pages/login.php");
	exit;
}
else{
	header("Location: ../index.php");
	exit;
}
