function initMap(restaurant){
    var map = L.map('map').setView([restaurant.latitude, restaurant.longitude], 17);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Ajouter des marqueurs pour les restaurants
    // var restaurants = [
    //     { name: "Restaurant 1", lat: 47.9011497999612, lon: 1.9052942 },
    // ];
    
    L.marker([restaurant.latitude, restaurant.longitude]).addTo(map)
        .bindPopup(restaurant.nomrestaurant)
        .openPopup();

}




// note
function noteStar(maNote){

    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll(".stars .star i");
        const hiddenInput = document.querySelector("input[name='nbEtoile']");
        const starsContainer = document.querySelector(".stars");
        if(stars != undefined && hiddenInput != undefined && starsContainer != undefined){

            if(maNote>5){
                maNote=5;
            }
            let selectedRating = maNote; 
            hiddenInput.value = selectedRating;
            updateStars(selectedRating);

            stars.forEach(star => {
                // Gestion du clic
                star.addEventListener("click", function (event) {
                    event.preventDefault(); // Empêche le saut de page
                    selectedRating = this.getAttribute("data-index");
                    hiddenInput.value = selectedRating;
                    starsContainer.classList.add("clicked"); // Active l'état cliqué
                    updateStars(selectedRating);
                });

                // Gestion du hover
                star.addEventListener("mouseover", function () {
                    updateStars(this.getAttribute("data-index"));
                });

                // Retour à la note sélectionnée en quittant le hover
                star.addEventListener("mouseout", function () {
                    updateStars(selectedRating);
                });
            });

            function updateStars(rating) {
                stars.forEach(s => {
                    const index = s.getAttribute("data-index");
                    if (index <= rating) {
                        s.parentElement.classList.add("staryellow");
                    } else {
                        s.parentElement.classList.remove("staryellow");
                    }
                });
            }
        }
    });
}

// function adjustH1Size() {
//     const h1 = document.querySelector('.fond > div h1'); 
//     const note = document.querySelector('.fond .note'); 
//     const windowWidth = window.innerWidth; 
//     const textLength = h1.textContent.length; 

//     let fontSize = (windowWidth / (textLength)); 

//     // fontSize = Math.max(16, Math.min(fontSize, 123)); // Taille minimale de 16px et maximale de 48px
//     h1.style.fontSize = `${fontSize}px`;

//     const h1Height = h1.offsetHeight; 
//     note.style.top = `${h1Height + 20}px`; 
// }

document.addEventListener('DOMContentLoaded', ()=>{
    // adjustH1Size();
    document.getElementById("submitComm").addEventListener("click",function(){
        document.getElementById("formComm").submit();
    })
});
// document.addEventListener('DOMContentLoaded', adjustH1Size);

// window.addEventListener('resize', adjustH1Size);
