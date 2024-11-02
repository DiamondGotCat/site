<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

require '../db.php';
$dbname = "kam_007";
$conn = getDbConnection($dbname);

// 受信メッセージの取得
$stmt = $conn->prepare("SELECT messages.id, users.username AS sender, messages.content, messages.image_path, messages.created_at 
                        FROM messages 
                        JOIN kam_005.users ON messages.sender_id = users.id 
                        WHERE messages.receiver_id = ? 
                        ORDER BY messages.created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);

// JSON形式でメッセージを返す
header('Content-Type: application/json');
echo json_encode($messages);

?>