document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("form");
    form.addEventListener("submit", function(e){
        e.preventDefault();
        const name  = document.getElementById("name");
        const surname  = document.getElementById("surname");
        const email  = document.getElementById("email");
        const username  = document.getElementById("username");
        const password  = document.getElementById("password");
        const confirmPassword  = document.getElementById("confirmPassword");

        if(name.value === ""){
            alert("Please write your name.");
            name.focus();
            return false;
        }
        if(surname.value === ""){
            alert("Please write your surname.");
            surname.focus();
            return false;
        }
        if(email.value === ""){

            alert("Please write your email.");
            email.focus();
            return false;
        }
        if(!emailValid(email.value)){
            alert("Please enter a valid email address.");
            email.focus();
            return false;
        }
        if(username.value === ""){
            alert("Please write your username.");
            username.focus()
            return false;
        }
        if(password.value === ""){
            alert("Please write your password.");
            password.focus();
            return false;
        }
        if(confirmPassword.value === ""){
            alert("Please confirm your password.");
            confirmPassword.focus();
            return false;
        }
        if(password.value !== confirmPassword.value){
            alert("Passwords do not match.");
            confirmPassword.focus();
            return false;
        }
        
        window.location.href = "Slider.html";
    });
    function emailValid(email){
        const emailRegex = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\.])+\.([A-Za-z]{2,4})$/;
        return emailRegex.test(email.toLowerCase());
    }
});