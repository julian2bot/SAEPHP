
# SAE PHP

## Membre du projet
Marques Julian (Chef de projet)  
Mathevet Chris  
Vilcoq Yohann  
Pavard Arthur  

## Lien du site
Nous avons un serveur, nous en avons donc profité pour le mettre en ligne ! Voici le lien du site:  

https://saerestaurant.marquesjulian.fr/

## Installation  

### BD  
Aller sur Supabase, se créer un compte et créer un nouveau projet.  

Une fois le projet créé, il suffit d'aller dans **SQL Editor**.  
En haut à gauche, on peut chercher les queries et, à côté, il y a un bouton **+**. Il faut cliquer dessus puis sur **Create a new snippet**.  

On met dedans le script de la création de table, puis on clique sur **Run** en bas à droite. On voit que tout a été créé et, dans les catégories à gauche, dans **PRIVATE**, on peut le déplacer à **SHARED** pour qu'il soit visible par tous.  
Une fois la table créée, on a tout.  

Pour créer la table sur MariaDB, c'est simplement une création de BD :  
`CREATE DATABASE name;`  
Puis, il suffit de copier-coller le script de création.  

### Le Site  

Pour lancer le site, il suffit d'aller à la racine du projet et d'exécuter la commande :  
```sh
php -S localhost:8080
```

Puis, se rendre sur cette URL dans notre navigateur.  

#### Utils  
Si la BD est vide ou si vous recréez la BD, vous devez exécuter le fichier `remplirBD.bat` ou `remplirBD.sh` selon votre distribution.  

### Fonctionnalités  

#### Principal  
- Recherche de restaurants dynamique (en cherchant avec le nom, ID, etc., et sans refresh de la page, on récupère et affiche les restaurants de la BD).  
- Recommandation en fonction des restaurants mis en favoris (prend les restos similaires).  
- Ajout aux favoris.  
- Voir les favoris.  
- Visualiser les restaurants avec leurs adresses, images, noms, etc.  
  - Les images sont obtenues via la BD s'il y en a.  
  - Sinon, les images sont obtenues via l'API Google Place en fonction des coordonnées du restaurant. Si l'image est trouvée, elle est mise dans la BD.  
  - S'il n'y a pas d'image dans la BD ni sur l'API Google, une image **placeholder** s'affiche.  

- Commentaires et notes sous un restaurant  
  - **Déconnecté**  
    - Voir les autres commentaires.  
  - **Connecté**  
    - Ajout  
    - Suppression  
    - Modification  

- **Administrateur**  
  - Suppression de tous les commentaires.  

- **Profil**  
  - Se connecter  
  - Se déconnecter  
  - Modifier son nom  
