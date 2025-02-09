// todo : ca marche pas jsp pourquoi?
export function formatUrlResto(osmid, nomrestaurant) {
    return `pages/restaurant.php?osmID=${osmid}&resto=${nomrestaurant}`;
    
    // return `/restaurant/${osmid}/${nomrestaurant.replace(/\s+/g, '-').toLowerCase()}`;
}

export function formatAdresseCommune(value) {
    return value.codecommune;
}

export function formatetoile(etoiles) {
    const fullStars = "★".repeat(etoiles);
    const emptyStars = "☆".repeat(5 - etoiles);
    console.log(`<span class="colorEtoile">${fullStars}</span> ${emptyStars}`);
    return `<span class="colorEtoile">${fullStars}</span> ${emptyStars}`;
}

export function formatCuisine(value) {
    
    let res="";
    for (const cuisine of value) {
        res += cuisine;
        console.log(res)
    }
    return res;
}


