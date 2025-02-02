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
