function toggleSearch(){

let searchBar = document.getElementById("searchBar");

if(searchBar.style.display === "none" || searchBar.style.display === ""){
searchBar.style.display = "flex";
} else{
searchBar.style.display = "none";
}

}

function searchRecipes(){
    let input = document.getElementById("searchInput").value.toLowerCase();
    let cards = document.querySelectorAll(".card");
    cards.forEach(card => {
        let text = card.textContent.toLowerCase();
        card.style.display = text.includes(input) ? "block" : "none";
    });
}



document.addEventListener("DOMContentLoaded", function() {
    const isAdmin = true;
    if(!isAdmin){
        document.getElementById("addRecipeBtn").style.display = "none";
    }
    window.toggleFavorite = function(btn){
        if(btn.textContent === "🤍"){
            btn.textContent = "❤️"; 
            btn.classList.add("favorited");
        } else {
            btn.textContent = "🤍"; 
            btn.classList.remove("favorited");
        }
    }

    
    window.showAddRecipeForm = function(){
        console.log("Admin: Open Add Recipe Form");
    }

});

function openFavorites() {
    console.log("Open Favorites page");
}

function openAccount() {
    console.log("Open Account page");
}


