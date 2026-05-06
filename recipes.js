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

function getRecipeNameFromButton(btn) {
    const card = btn.closest(".card");
    if (!card) return "";
    const titleElement = card.querySelector(".card-title p");
    return titleElement ? titleElement.textContent.trim() : "";
}

function saveFavorite(recipeName) {
    return fetch(getFavoritesApiUrl("add"), {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        credentials: "same-origin",
        body: "name=" + encodeURIComponent(recipeName)
    }).then(parseApiResponse);
}

function removeFavorite(recipeName) {
    return fetch(getFavoritesApiUrl("remove"), {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        credentials: "same-origin",
        body: "name=" + encodeURIComponent(recipeName)
    }).then(parseApiResponse);
}

function getFavoritesApiUrl(action) {
    return "favorites.php?action=" + encodeURIComponent(action);
}

function parseApiResponse(res) {
    return res.text().then(text => {
        try {
            return JSON.parse(text);
        } catch (e) {
            return {
                success: false,
                message: text || "Serveri nuk ktheu pergjigje valide."
            };
        }
    });
}

function applyFavoriteState(btn, isFavorited) {
    if (isFavorited) {
        btn.textContent = "❤️";
        btn.classList.add("favorited");
    } else {
        btn.textContent = "🤍";
        btn.classList.remove("favorited");
    }
}

function loadFavoriteStates() {
    fetch(getFavoritesApiUrl("get"), { credentials: "same-origin" })
        .then(parseApiResponse)
        .then(data => {
            if (!Array.isArray(data)) return;

            const favorites = new Set(
                data.map(item => (item.item_name || "").trim().toLowerCase())
            );

            document.querySelectorAll(".favorite-btn").forEach(btn => {
                const recipeName = getRecipeNameFromButton(btn).toLowerCase();
                applyFavoriteState(btn, favorites.has(recipeName));
            });
        })
        .catch(() => {
            // If user is not logged in, keep default hearts.
        });
}



document.addEventListener("DOMContentLoaded", function() {
    if (window.location.protocol === "file:") {
        alert("Hape faqen nga localhost, jo file:// . Shembull: http://localhost/Projekti1/recipes.html");
    }

    const isAdmin = true;
    if(!isAdmin){
        document.getElementById("addRecipeBtn").style.display = "none";
    }
    window.toggleFavorite = function(btn){
        const recipeName = getRecipeNameFromButton(btn);
        if (!recipeName) {
            alert("Nuk u gjet emri i recetes.");
            return;
        }

        const willBeFavorited = btn.textContent === "🤍";
        const request = willBeFavorited ? saveFavorite(recipeName) : removeFavorite(recipeName);

        request
            .then(data => {
                if (data.success) {
                    applyFavoriteState(btn, willBeFavorited);
                } else {
                    alert(data.message || "Nuk u krye veprimi per favorite.");
                }
            })
            .catch(() => {
                const apiUrl = getFavoritesApiUrl(willBeFavorited ? "add" : "remove");
                alert("Gabim gjate lidhjes me serverin.\nKontrollo qe je ne localhost.\nURL: " + apiUrl);
            });
    }

    
    window.showAddRecipeForm = function(){
        console.log("Admin: Open Add Recipe Form");
    }

    loadFavoriteStates();
});

function openFavorites() {
    console.log("Open Favorites page");
}

function openAccount() {
    console.log("Open Account page");
}


