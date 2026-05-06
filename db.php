<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "favorites";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage() . " | DB: " . $dbname . " | File: " . __FILE__);
}

try {
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        name VARCHAR(100) DEFAULT NULL,
        surname VARCHAR(100) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $conn->query("CREATE TABLE IF NOT EXISTS recipes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        image VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $conn->query("CREATE TABLE IF NOT EXISTS favorites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_user_item (user_id, item_name)
    )");
} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}

function debug_query($conn, $sql, $params = []) {
    $log = "[" . date('Y-m-d H:i:s') . "] Query: " . $sql . "\n";
    $log .= "Params: " . print_r($params, true) . "\n";
    file_put_contents('debug_log.txt', $log, FILE_APPEND);
}
?>