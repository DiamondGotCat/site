<?php
// memo.php
session_start();

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    header("Location: ../id/index.php");
    exit();
}

require '../db.php';
$dbname = "kam_006";
$conn = getDbConnection($dbname);

// メモの追加処理
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_memo'])) {
    $content = trim($_POST['content']);
    if (!empty($content)) {
        $stmt = $conn->prepare("INSERT INTO memos (user_id, content) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION['user_id'], $content);
        $stmt->execute();
        $stmt->close();
    }
}

// メモの削除処理
if (isset($_GET['delete'])) {
    $memo_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM memos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $memo_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

// メモの取得
$stmt = $conn->prepare("SELECT id, content, created_at FROM memos WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$memos = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Kamu メモ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl">Kamu メモ</h1>
            <a href="../id/home.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ホームに戻る</a>
        </div>

        <!-- メモ追加フォーム -->
        <div class="mb-8 bg-gray-800 p-6 rounded">
            <h2 class="text-2xl mb-4">新しいメモを追加</h2>
            <form method="POST" action="index.php">
                <textarea name="content" rows="4" required class="w-full p-2 bg-gray-700 text-white rounded mb-4" placeholder="メモ内容を入力してください..."></textarea>
                <button type="submit" name="add_memo" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">追加</button>
            </form>
        </div>

        <!-- メモ一覧 -->
        <div class="bg-gray-800 p-6 rounded">
            <h2 class="text-2xl mb-4">あなたのメモ</h2>
            <?php if (count($memos) > 0): ?>
                <ul>
                    <?php foreach ($memos as $memo): ?>
                        <li class="mb-4 p-4 bg-gray-700 rounded flex justify-between items-start">
                            <div>
                                <p class="whitespace-pre-wrap"><?= htmlspecialchars($memo['content'], ENT_QUOTES, 'UTF-8') ?></p>
                                <span class="text-sm text-gray-400">作成日: <?= htmlspecialchars($memo['created_at']) ?></span>
                            </div>
                            <a href="memo.php?delete=<?= $memo['id'] ?>" onclick="return confirm('本当に削除しますか？');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">削除</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-400">まだメモがありません。</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>