document.addEventListener("DOMContentLoaded", function(){

    const closeProfile = document.getElementById("closeProfile")
    const openProfile = document.getElementById("openProfil")
    closeProfile.addEventListener("click", closeProfilefunc )
    openProfile.addEventListener("click", (e)=>openProfilefunc(e) )



    const closeProfileEdit = document.getElementById("closeProfileEdit")
    const openProfileEdit = document.getElementById("openProfileEdit")
    closeProfileEdit.addEventListener("click", closeEditProfile )
    openProfileEdit.addEventListener("click", openEditProfile )

});

function closeProfilefunc(){
    document.getElementById("profile").style.display ="none"
}
function openProfilefunc(e){
    e.preventDefault();
    
    document.getElementById("profile").style.display ="block"
}


function closeEditProfile(){
    document.getElementById("profileEdit").style.display ="none"
}
function openEditProfile(){
    document.getElementById("profileEdit").style.display ="block"
}