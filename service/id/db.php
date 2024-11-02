<?php
$servername = "localhost";
$username = "kam_root";  // あなたのMySQLユーザ名
$password = "Admin565628";  // あなたのMySQLパスワード
$dbname = "kam_005";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>