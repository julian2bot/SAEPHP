document.addEventListener('DOMContentLoaded', function() {
    const positionHearts = document.querySelectorAll('.positionHeart');
    const currentUrl = window.location.href;
    const restaurantUrlPattern = /osmID=node\/\d+/;

    // pour tous les éléments coeur fav
    positionHearts.forEach(function(heart) {
        let osmID = null;
        const parentElement = heart.parentElement?.parentElement;

        // pour index et la page fav l'id est dans le parent <a>
        if (parentElement && parentElement.tagName.toLowerCase() === 'a') {
            const url = new URL(parentElement.href);
            const urlParams = new URLSearchParams(url.search);
            osmID = urlParams.get('osmID');
        } else if (restaurantUrlPattern.test(currentUrl)) {
            // pour la page du resto l'id est dans l'url
            const urlParams = new URLSearchParams(window.location.search);
            osmID = urlParams.get('osmID');
        } else {
            // sinon erreur
            console.log(osmID);
            console.error('Parent element is not an <a> tag and not on a restaurant page');
        }
        console.log(osmID);

        heart.addEventListener('click', function(event) {
            event.preventDefault();
            // ça fait un like
            if (heart.classList.contains('heartsgrey')) {
                heart.classList.remove('heartsgrey');
                heart.classList.add('hearts');
            } else {
                heart.classList.remove('hearts');
                heart.classList.add('heartsgrey');
            }

            // Play the animation
            heart.classList.add('heartactive');
            setTimeout(() => heart.classList.remove('heartactive'), 1000);

            // Update la db
            const endpointUrl = '../controleur/favoris.php';
            const state = heart.classList.contains('hearts') ? 'hearts' : 'heartsgrey';
            const body = `osmID=${encodeURIComponent(osmID)}&state=${encodeURIComponent(state)}`;

            fetch(endpointUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: body
            }).then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur : ${response.status}`);
                }
                return response.json();
            }).then(data => console.log(data))
              .catch(error => console.error('Error:', error));
        });
    });
});