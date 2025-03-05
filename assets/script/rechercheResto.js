import { formatUrlResto, formatCuisine, formatetoile, formatAdresseCommune } from './formatage.js';


function getRestoChercher(valueInput) {
    const url = "../controleur/rechercheResto.php"; // todo : edit si le nom du fichier change
    
    // Utilisation de fetch avec une requête POST
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "nomRestoCuisine=" + encodeURIComponent(valueInput)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur : ${response.status}`);
        }
        return response.json(); // Parse la réponse JSON
    })
    .then(data => {
        // console.log(data);
        // Ici, tu peux traiter ta réponse
        afficherRestos(data);
        remplirDataListe(data);
    })
    .catch(error => {
        console.error(error);
    });
}

function afficherRestos(restos) {
    const resultatContainer = document.getElementById('resultat');
    
    resultatContainer.innerHTML = "";

    restos.forEach(value => {
        const restoDiv = document.createElement('div');
        restoDiv.classList.add('resto');

        restoDiv.innerHTML = remplirResto(value);

        resultatContainer.appendChild(restoDiv);
    });
}

function remplirResto(value){
let heartSpan = '';
    if (value.user) {
        heartSpan = `<span class="${value.favori ? 'hearts' : 'heartsgrey'} positionHeart"> ❤ </span>`;
    }
    return `<a href="${formatUrlResto(value.osmid, value.nomrestaurant)}">
                <div class="nomnote">
                    <p class="soustitre">${value.nomrestaurant}</p>
                    <div class="note">${formatetoile(value.etoiles ?? 0)}</div>
                    <div>${value.etoiles ?? 0}/5</div>
                    ${heartSpan}
</div>
                <div class="adresse">
                    <p>${formatAdresseCommune(value)}</p>
                </div>
                <div class="attr">
                    <p>🍽</p>
                    <p>${formatCuisine(value.cuisines)? formatCuisine(value.cuisines) : "Pas de cuisine"}</p>
                </div>
            </a>
        `;
}

function remplirDataListe(restos) {
    const resultatContainer = document.getElementById('liste-restaurant');
    
    resultatContainer.innerHTML = "";

    restos.forEach(value => {
        const restOption = document.createElement('option');

        restOption.value = value.nomrestaurant;
        resultatContainer.appendChild(restOption);
    });
}


// document.addEventListener('DOMContentLoaded', function() {

//     const inputField = document.getElementById('donne');
//     let plusDe3 = false;

//     function checkInput() {
//         const inputValue = inputField.value;

//         if (inputValue.length >= 3 && !plusDe3) {
//             plusDe3 = true; 
//             // console.log(inputValue.trim());
//             getRestoChercher(inputValue.trim());
//         }
//         if (inputValue.length <= 3) {
//             plusDe3 = false;  
//         }
//     }

//     inputField.addEventListener('input', checkInput);
//     inputField.addEventListener('paste', checkInput);


//     const form = document.querySelector('.custom_input'); 

//     form.addEventListener('submit', function(event) {
//         event.preventDefault(); 
        
//         const inputValue = inputField.value;
//         getRestoChercher(inputValue.trim())
//         // console.log("Valeur de l'input :", inputValue); 
//     });
// });


function handleInputChange(inputField, plusDe3, setPlusDe3) {
    const inputValue = inputField.value.trim();

    if (inputValue.length >= 3 && !plusDe3) {
        setPlusDe3(true);
        getRestoChercher(inputValue); 
    }

    if (inputValue.length < 3) {
        setPlusDe3(false);
    }
}

function handleFormSubmit(form, inputField) {
    form.addEventListener('submit', function(event) {
        event.preventDefault();  

        const inputValue = inputField.value.trim();
        getRestoChercher(inputValue); 
    });
}

function initialize() {
    const inputField = document.getElementById('donne');
    let plusDe3 = false;

    function setPlusDe3(value) {
        plusDe3 = value;
    }

    inputField.addEventListener('input', () => handleInputChange(inputField, plusDe3, setPlusDe3));
    inputField.addEventListener('paste', () => handleInputChange(inputField, plusDe3, setPlusDe3));

    const form = document.querySelector('.custom_input');
    handleFormSubmit(form, inputField);
}

document.addEventListener('DOMContentLoaded', initialize);


