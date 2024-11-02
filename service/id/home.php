<?php
session_start();

// ユーザーがログインしているかを確認
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// ログアウト処理
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamu Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto">
        <h1 class="text-center text-4xl mt-10">Kamu Services</h1>

        <div class="max-w-md mx-auto mt-10 bg-gray-800 p-5 rounded">
            <h2 class="text-2xl mb-4">Welcome to Kamu Services</h2>

            <!-- Kamu メモへのリンク -->
            <div class="mb-4">
                <a href="../memo/" class="w-full block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    Kamu メモ
                </a>
            </div>

            <!-- Kamu メッセージへのリンク -->
            <div class="mb-4">
                <a href="../message/" class="w-full block bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center">
                    Kamu メッセージ
                </a>
            </div>

            <!-- ログアウトボタン -->
            <div class="mb-4">
                <a href="home.php?logout=true" class="w-full block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                    ログアウト
                </a>
            </div>
        </div>
    </div>
</body>
</html>