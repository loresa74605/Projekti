<?php
include "db.php";
session_start();

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM recipes WHERE user_id='$user_id'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    echo "<h2>".$row['title']."</h2>";
    echo "<p>".$row['description']."</p>";
    echo "<img src='images/".$row['image']."' width='200'>";
}
?>