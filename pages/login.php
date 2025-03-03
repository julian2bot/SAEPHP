<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link rel="stylesheet" href="../assets/style/reset.css">
    <link rel="stylesheet" href="../assets/style/all.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/login.css">
</head>
<body>
    <?php
        require "../assets/affichage/header.php";
    ?>
    <main>

        <div class="login-container">
            <div class="login-box">
                <h2 class="title">CONNEXION</h2>
                <form  action="../modele/login.php" method="POST">
                    <label for="username">NOM D'UTILISATEUR</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">MOT DE PASSE</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" name="formLogin" >SE CONNECTER</button>
                    <a href="inscription.php" class="switch">S'inscrire</a>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
