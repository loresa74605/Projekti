<?php
ini_set("display_errors", 0);
error_reporting(E_ALL);

include "db.php";
session_start();

header("Content-Type: application/json");

$user_id = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
} elseif (isset($_COOKIE['tb_user_id']) && ctype_digit($_COOKIE['tb_user_id'])) {
    $user_id = (int)$_COOKIE['tb_user_id'];
    $_SESSION['user_id'] = $user_id;
}

if ($user_id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Duhet te kyqesh user-in."
    ]);
    exit();
}
$action = $_GET['action'] ?? '';

try {
    $conn->query("CREATE TABLE IF NOT EXISTS favorites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_user_item (user_id, item_name)
    )");

    $favoriteColumn = "item_name";
    $hasItemName = $conn->query("SHOW COLUMNS FROM favorites LIKE 'item_name'")->num_rows > 0;
    if (!$hasItemName) {
        $hasName = $conn->query("SHOW COLUMNS FROM favorites LIKE 'name'")->num_rows > 0;
        if ($hasName) {
            $favoriteColumn = "name";
        } else {
            // If neither exists, create item_name and continue.
            $conn->query("ALTER TABLE favorites ADD COLUMN item_name VARCHAR(255) NOT NULL");
            $favoriteColumn = "item_name";
        }
    }

    if ($action === "add") {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            echo json_encode([
                "success" => false,
                "message" => "Emri i recetes mungon."
            ]);
            exit();
        }

        $stmt = $conn->prepare("INSERT IGNORE INTO favorites (user_id, $favoriteColumn) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $name);
        $stmt->execute();

        echo json_encode([
            "success" => true,
            "message" => "Receta u shtua ne favorites."
        ]);
        exit();
    }

    if ($action === "get") {
        $hasCreatedAt = $conn->query("SHOW COLUMNS FROM favorites LIKE 'created_at'")->num_rows > 0;
        $orderBy = $hasCreatedAt ? "created_at DESC" : "id DESC";
        $stmt = $conn->prepare("SELECT 
                f.$favoriteColumn AS item_name,
                (
                    SELECT r.image
                    FROM recipes r
                    WHERE r.title = f.$favoriteColumn
                    ORDER BY r.id DESC
                    LIMIT 1
                ) AS image
            FROM favorites f
            WHERE f.user_id = ?
            ORDER BY f.$orderBy");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $favorites = [];
        while ($row = $result->fetch_assoc()) {
            $favorites[] = $row;
        }

        echo json_encode($favorites);
        exit();
    }

    if ($action === "remove") {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            echo json_encode([
                "success" => false,
                "message" => "Emri i recetes mungon."
            ]);
            exit();
        }

        $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND $favoriteColumn = ?");
        $stmt->bind_param("is", $user_id, $name);
        $stmt->execute();

        echo json_encode([
            "success" => true,
            "message" => "Receta u hoq nga favorites."
        ]);
        exit();
    }

    echo json_encode([
        "success" => false,
        "message" => "Action i panjohur."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Gabim ne databaze: " . $e->getMessage()
    ]);
}
?>