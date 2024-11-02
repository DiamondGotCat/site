<?php
// db.php
$servername = "localhost";
$username = "kam_root"; // あなたのMySQLユーザ名
$password = "Admin565628"; // あなたのMySQLパスワード

// データベース名はサービスごとに変更します
// 使用時に $dbname を設定してください

// 接続を確立する関数
function getDbConnection($dbname) {
    global $servername, $username, $password;
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // 接続チェック
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    // 文字セットを設定
    $conn->set_charset("utf8mb4");
    return $conn;
}
?>