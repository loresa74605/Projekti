<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tinybites";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

function debug_query($conn, $sql, $params = []) {
    $log = "[" . date('Y-m-d H:i:s') . "] Query: " . $sql . "\n";
    $log .= "Params: " . print_r($params, true) . "\n";
    file_put_contents('debug_log.txt', $log, FILE_APPEND);
}
?>