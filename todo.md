Objectif du Projet

Créer une application web nommée "IUTables'O" pour gérer et visualiser les caractéristiques de 382 restaurants d'Orléans, en utilisant les données fournies dans le fichier restaurants_orleans.json.
Fonctionnalités
Pour les Visiteurs Non Authentifiés

    Recherche de restaurants par type, cuisine, et autres critères.
    Inscription et connexion.
    Visualisation des caractéristiques des restaurants.

Pour les Visiteurs Enregistrés

    Visualisation des notes et critiques laissées par d'autres utilisateurs.
    Accès et gestion de leur profil.
    Administration de leurs propres critiques.

Fonctionnalités Optionnelles

    Écran d'accueil avec les meilleurs restaurants.
    Gestion des types de cuisine préférés.
    Affichage des restaurants préférés.
    Adaptation des recherches selon les goûts de l'utilisateur.
    Profil modérateur pour contrôler les critiques.

Modèle de Données

    Chaque restaurant doit être une occurrence de l'entité principale.
    Les restaurants peuvent avoir des photos et plusieurs caractéristiques.
    Les utilisateurs enregistrés peuvent laisser des critiques (note de 1 à 5 et commentaire).
    Les utilisateurs peuvent aimer des restaurants et préférer certains types de cuisine.

Tests Unitaires

    Utilisation de PHPUnit via Composer.
    Taux de couverture minimum de 80%.

Contraintes Techniques
Partie Web

    Code organisé de manière cohérente.
    Utilisation de PHP et éventuellement JavaScript.
    Utilisation des namespaces.
    Chargement du fichier JSON via un provider.
    Utilisation d'un autoloader pour les classes.
    Gestion des sessions.
    Connexion à la base de données via PDO.
    Utilisation du patron MVC.