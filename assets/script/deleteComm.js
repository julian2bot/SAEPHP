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
            } else {
                // alert("Erreur : " + data.message);
                document.getElementById(username).setAttribute('style', 'display:inherit !important');
            }
            showPopUp(data.message, data.success);

        })
        .catch(error =>{
            console.error("Erreur :", error);  
            showPopUp("Erreur : " + error, false);
            document.getElementById(username).setAttribute('style', 'display:inherit !important');
        })
    }
}
