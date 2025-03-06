<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

    <link rel="stylesheet" href="../assets/style/reset.css">
    <link rel="stylesheet" href="../assets/style/all.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/login.css">
    <script src="../assets/script/popUpGestionErr.js"></script>
</head>
<body>
    <?php
        require "../assets/affichage/header.php";
    ?>
    <main>

        <div class="login-container">
            <div class="login-box">
                <h2 class="title">INSCRIPTION</h2>
                <form action="../controleur/inscription.php" method="POST">
                    <label for="username">NOM D'UTILISATEUR</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">MOT DE PASSE</label>
                    <input type="password" id="password" name="password" required>

                    <label for="password">CONFIRMATION MOT DE PASSE</label>
                    <input type="password" id="repassword" name="repassword" required>

                    <button type="submit" name="formInscription">S'INSCRIRE</button>
                    <a href="login.php" class="switch">Se connecter </a>

                </form>
            </div>
        </div>
    </main>

</body>
</html>
