const fallbackImages = {
    "pavlova bombs": "pavlova.png",
    "fruity pancakes": "pancakes.png",
    "rocky road": "cakes.png",
    "black forest cake": "choc.png",
    "frosting cupcakes": "frosting.png",
    "vanilla filled chocolate cupcakes": "cupchoc.png",
    "creme brulee": "cremebrule.png",
    "pudding pots": "puddingpots.png",
    "panna cotta": "pannacotta.png",
    "panacotta": "pannacotta.png",
    "cremebrulee": "cremebrule.png",
    "cupcake": "cupchoc.png"
};

function getImageForFavorite(recipeName, dbImage) {
    if (dbImage && dbImage.trim() !== "") {
        return "images/" + dbImage;
    }

    const key = recipeName.trim().toLowerCase();
    return fallbackImages[key] || "pavlova.png";
}

function loadFavorites() {
    fetch("favorites.php?action=get")
    .then(parseApiResponse)
    .then(data => {
        let list = document.getElementById("favoritesList");
        list.innerHTML = "";

        if (!Array.isArray(data)) {
            const msg = data && data.message ? data.message : "Duhet te kyqesh user-in per t'i pare favorites.";
            list.innerHTML = "<li>" + msg + "</li>";
            return;
        }

        if (data.length === 0) {
            list.innerHTML = "<li>You have not saved any favorite recipes yet.</li>";
            return;
        }

        data.forEach(item => {
            const recipeName = item.item_name || item.name;
            let li = document.createElement("li");

            const image = document.createElement("img");
            image.className = "favorite-image";
            image.src = getImageForFavorite(recipeName, item.image);
            image.alt = recipeName;

            const content = document.createElement("div");
            content.className = "favorite-content";

            const nameSpan = document.createElement("span");
            nameSpan.className = "favorite-title";
            nameSpan.innerText = recipeName;
            content.appendChild(nameSpan);

            const removeBtn = document.createElement("button");
            removeBtn.className = "remove-btn";
            removeBtn.innerText = "Hiq";
            removeBtn.onclick = function () {
                removeFavorite(recipeName);
            };

            li.appendChild(image);
            li.appendChild(content);
            li.appendChild(removeBtn);
            list.appendChild(li);
        });
    })
    .catch(() => {
        let list = document.getElementById("favoritesList");
        list.innerHTML = "<li>Gabim gjate ngarkimit te favorites.</li>";
    });
}

function removeFavorite(name) {
    fetch("favorites.php?action=remove", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "name=" + encodeURIComponent(name)
    })
    .then(parseApiResponse)
    .then(data => {
        if (data.success) {
            loadFavorites();
        } else {
            alert(data.message || "Nuk u hoq receta.");
        }
    })
    .catch(() => {
        alert("Gabim gjate lidhjes me serverin.");
    });
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

loadFavorites();