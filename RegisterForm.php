<?php
include "db.php";
session_start();
file_put_contents('debug_log.txt', "[" . date('Y-m-d H:i:s') . "] Visit to RegisterForm.php | Method: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmpassword = $_POST['confirmpassword'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        die("Please fill in all required fields.");
    }

    if ($password !== $confirmpassword) {
        die("Passwords do not match!");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (username, email, password, name, surname) VALUES (?, ?, ?, ?, ?)";
        debug_query($conn, $sql, [$username, $email, 'HASHED_PWD', $name, $surname]);
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $email, $hashed_password, $name, $surname);
        
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $conn->insert_id;

            header("Location: Slider.html");
            exit();
        }
    } catch (Exception $e) {
        die("Database Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="RegisterForm.css">
</head>
<body>
<div class="register-box">
    <form action="RegisterForm.php" method="POST">
        <input type="text" name="name" id="name" placeholder="Name" required><br><br>
        <input type="text" name="surname" id="surname" placeholder="Surname" required><br><br>
        <input type="email" name="email" id="email" placeholder="Email" required><br><br>
        <input type="text" name="username" id="username" placeholder="Username" required><br><br>
        <input type="password" name="password" id="password" placeholder="Password" required><br><br>
        <input type="password" name="confirmpassword" id="confirmPassword" placeholder="Confirm Password" required><br><br>
        <button type="submit">Register</button>
        <p class="p1">Already have an account?
            <br>
            <a href="LoginForm.html" class="p2">Log in</a>
        </p>
    </form>
</div>

</body>
</html>