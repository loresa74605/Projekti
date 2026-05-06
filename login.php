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

            $storedPassword = $row['password'] ?? '';
            $passwordInfo = password_get_info($storedPassword);
            $isHashedPassword = !empty($passwordInfo['algo']);
            $isValidLogin = false;

            if ($isHashedPassword) {
                $isValidLogin = password_verify($password, $storedPassword);
            } else {
                // Backward compatibility for old plain-text accounts.
                $isValidLogin = hash_equals((string)$storedPassword, (string)$password);

                // Migrate old plain password to hashed password after first successful login.
                if ($isValidLogin) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $updateStmt->bind_param("si", $newHash, $row['id']);
                    $updateStmt->execute();
                }
            }

            if ($isValidLogin) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                setcookie("tb_user_id", (string)$row['id'], time() + (86400 * 30), "/");
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