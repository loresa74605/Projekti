<?php
include "db.php";
session_start();

// LOG ALL VISITS
file_put_contents('debug_log.txt', "[" . date('Y-m-d H:i:s') . "] Visit to login.php | Method: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Note: password_verify works ONLY with hashed passwords.
            // If your database has plain text passwords (like '123'), it will fail.
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header("Location: Slider.html");
                exit();
            } else {
                echo "Password gabim! (Ose account-i nuk ka password te hash-uar)";
            }
        } else {
            echo "Username nuk ekziston!";
        }
    } catch (Exception $e) {
        die("Database Error: " . $e->getMessage());
    }
}
?>