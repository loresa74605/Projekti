function toggleSearch(){

let searchBar = document.getElementById("searchBar");

if(searchBar.style.display === "none" || searchBar.style.display === ""){
searchBar.style.display = "flex";
} else{
searchBar.style.display = "none";
}

}