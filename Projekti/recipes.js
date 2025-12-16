function searchRecipes(){
    let input = document.getElementById("searchInput").value.toLowerCase();
    let cards = document.querySelectorAll(".card");
    cards.forEach(card => {
        let text = card.textContent.toLowerCase();
        card.style.display = text.includes(input) ? "block" : "none";
    });
}