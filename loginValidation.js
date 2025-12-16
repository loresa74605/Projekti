document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("form");

    form.addEventListener("submit", function(e){
        e.preventDefault();

        const username = document.getElementById("username");
        const password = document.getElementById("password");

        if(username.value ===""){
            alert("Please enter your username.");
            username.focus();
            return false;
        }
        if(password.value === ""){
            alert("Please enter your password.");
            password.focus();
            return false;
        }
        if(password.value.length <8 || password.value.length >20){
            alert("Password must be between 8 and 20 characters");
            password.focus();
            return false;
        }
        window.location.href="Slider.html";

    });
});