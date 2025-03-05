function supprimerCommentaire(username, osmID) {
    if (confirm("Voulez-vous vraiment supprimer ce commentaire ?")) {
        document.getElementById(username).setAttribute('style', 'display:none !important');
        fetch("../controleur/commentaires/commentaireSuppressionAdmin.php", {
            method: "POST",
            headers: { 
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `username=${encodeURIComponent(username)}&osmID=${encodeURIComponent(osmID)}`
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.success) {
                document.getElementById(username).remove();
                alert(data.message);
            } else {
                alert("Erreur : " + data.message);
                document.getElementById(username).setAttribute('style', 'display:inherit !important');
            }
        })
        .catch(error =>{
          console.error("Erreur :", error);  
          document.getElementById(username).setAttribute('style', 'display:inherit !important');
        })
    }
}
