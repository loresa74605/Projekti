<?php
include "db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $desc = $_POST['description'] ?? '';
    $user_id = $_SESSION['user_id'];

    $image = $_FILES['image']['name'] ?? '';
    $tmp_name = $_FILES['image']['tmp_name'] ?? '';
    
    if ($image) {
        if (!file_exists("images")) {
            mkdir("images", 0777, true);
        }
        move_uploaded_file($tmp_name, "images/" . $image);
    }

    try {
        $stmt = $conn->prepare("INSERT INTO recipes (user_id, title, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $title, $desc, $image);
        
        if ($stmt->execute()) {
            echo "Receta u shtua me sukses!";
        }
    } catch (Exception $e) {
        die("Gabim: " . $e->getMessage());
    }
}
?>