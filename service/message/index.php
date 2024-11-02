<?php
// message.php
session_start();

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    header("Location: ../id/index.php");
    exit();
}

require '../db.php';
$dbname = "kam_007";
$conn = getDbConnection($dbname);

$error = "";
$success = "";

// メッセージの送信処理
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {
    $receiver_email = trim($_POST['receiver_email']);
    $content = trim($_POST['content']);
    $image_path = null;

    // 受信者のメールアドレスが有効かチェック
    $stmt = $conn->prepare("SELECT id FROM kam_005.users WHERE email = ?");
    $stmt->bind_param("s", $receiver_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // メールアドレスが存在する場合、送信処理を進める
        $stmt->bind_result($receiver_id);
        $stmt->fetch();
        $stmt->close();  // ステートメントを適切に閉じる

        // 画像のアップロード処理
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= 20 * 1024 * 1024) { // 20MB
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . "." . $ext;
                $destination = 'uploads/' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $image_path = $destination;
                }
            }
        }

        // メッセージの挿入
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, content, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $_SESSION['user_id'], $receiver_id, $content, $image_path);
        $stmt->execute();
        $success = "メッセージが送信されました。";
    } else {
        // メールアドレスが見つからない場合
        $error = "指定されたメールアドレスは存在しません。";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Kamu メッセージ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl">Kamu メッセージ</h1>
            <a href="../id/home.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ホームに戻る</a>
        </div>

        <!-- エラーメッセージの表示 -->
        <?php if ($error): ?>
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <!-- 成功メッセージの表示 -->
        <?php if ($success): ?>
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <!-- メッセージ送信フォーム -->
        <div class="mb-8 bg-gray-800 p-6 rounded">
            <h2 class="text-2xl mb-4">メッセージを送信</h2>
            <form method="POST" action="index.php" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="receiver_email" class="block text-sm font-medium mb-2">送信先のメールアドレス</label>
                    <input type="email" name="receiver_email" id="receiver_email" required class="w-full p-2 bg-gray-700 text-white rounded" placeholder="メールアドレスを入力してください">
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium mb-2">メッセージ内容</label>
                    <textarea name="content" id="content" rows="4" class="w-full p-2 bg-gray-700 text-white rounded" placeholder="メッセージを入力してください..."></textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium mb-2">画像を添付 (最大20MB)</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full p-2 bg-gray-700 text-white rounded">
                </div>
                <button type="submit" name="send_message" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">送信</button>
            </form>
        </div>
        <!-- メッセージ一覧 -->
        <div class="bg-gray-800 p-6 rounded">
            <h2 class="text-2xl mb-4">受信メッセージ</h2>
            <ul id="messageList" class="space-y-4">
                <!-- ここにメッセージが動的に表示されます -->
            </ul>
        </div>
    </div>
   

    <script>
        // 定期的にメッセージを取得する関数
        async function fetchMessages() {
            try {
                const response = await fetch('fetch_messages.php');
                if (!response.ok) {
                    throw new Error('Failed to fetch messages');
                }

                const messages = await response.json();
                const messageList = document.getElementById('messageList');
                messageList.innerHTML = ''; // リストをクリア

                messages.forEach(message => {
                    const li = document.createElement('li');
                    li.classList.add('p-4', 'bg-gray-700', 'rounded');

                    // メッセージ内容を表示
                    li.innerHTML = `
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold">from ${message.sender}</span>
                            <span class="text-sm text-gray-400">${message.created_at}</span>
                        </div>
                        <p class="whitespace-pre-wrap mb-2">${message.content ? message.content : ''}</p>
                        ${message.image_path ? `<img src="${message.image_path}" alt="Image" class="max-w-full h-auto rounded">` : ''}
                    `;

                    messageList.appendChild(li);
                });
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        }

        // 5秒ごとにメッセージを取得
        setInterval(fetchMessages, 1000);

        // ページ読み込み時に一度メッセージを取得
        fetchMessages();
    </script>
</body>
</html>