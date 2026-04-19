document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {

        const name = document.getElementById("name");
        const surname = document.getElementById("surname");
        const email = document.getElementById("email");
        const username = document.getElementById("username");
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirmPassword");

        // validation flag
        let valid = true;

        if (name.value === "") {
            alert("Please write your name.");
            valid = false;
        }

        if (surname.value === "") {
            alert("Please write your surname.");
            valid = false;
        }

        if (email.value === "") {
            alert("Please write your email.");
            valid = false;
        }

        if (username.value === "") {
            alert("Please write your username.");
            valid = false;
        }

        if (password.value === "") {
            alert("Please write your password.");
            valid = false;
        }

        if (confirmPassword.value === "") {
            alert("Please confirm your password.");
            valid = false;
        }

        if (password.value !== confirmPassword.value) {
            alert("Passwords do not match.");
            valid = false;
        }

        // ONLY block if invalid
        if (!valid) {
            e.preventDefault();
        }

        // DO NOT redirect here
    });
});