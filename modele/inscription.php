<?php
require_once "../utils/BD/connexionBD.php";
require_once "../utils/BD/requettes/select.php";
require_once "../utils/BD/requettes/userManagement.php";


// code pour se login verifier s'il est bien dans la BD et mettre toute les valeurs dans le $_SESSION

print_r($_SESSION);


if(isset($_POST['formInscription'])){

    echo "bouton ok";

	$username = htmlspecialchars($_POST['username']);
	// $pass2 = /*password_hash*/sha1($_POST['PassWordLogin']/*, PASSWORD_DEFAULT*/);
    $mdp = hash('sha256', $_POST['password']);
    $mdp = hash('sha256', $_POST['repassword']);
	
	if(!empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['repassword'])){
        
        if($_POST['password'] === $_POST['repassword']){

            echo "username et password ok";
            echo $_POST['username']." " .$_POST['password']." " .$_POST['repassword'];
            
            $user = new User($bdd);
            if($user -> usernameExist($username)){
                echo "utilisateur connu";
                $erreur =  "L'utilisateur existe deja !";
            }else{	
                echo "utilisateur inconnu";
                $user -> createUser($username, $mdp);
                $user ->userConnecter($username);
            }   
        }else{
    		$erreur =  "Les mots de passe ne correspondes pas !";

        }
    }   
        
	else{
		$erreur =  "Tous les champs doivent être complétés!";
	}

}


// retourne sur la page index avec l'erreur s'il y en a une 
if($erreur){
	header("Location: ../pages/login.php?erreurLogin=$erreur");
	exit;
}
else{
	header("Location: ../index.php");
	exit;
}
