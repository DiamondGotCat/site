<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>T2U - Kamu Japan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5309485435511985" crossorigin="anonymous"></script>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f3f4f6;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background-color: #3b82f6;
      color: white;
      padding: 1rem;
    }
    .container {
      max-width: 1024px;
      margin: 0 auto;
      padding: 0 1rem;
    }
    nav ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    nav ul li {
      display: inline-block;
      margin-right: 1rem;
    }
    nav ul li:last-child {
      margin-right: 0;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
    }
    section {
      padding: 2rem 0;
    }
    #apps {
      display: flex;
      justify-content: center;
    }
    form {
      display: flex;
      align-items: center;
      background-color: white;
      border-radius: 1rem;
      padding: 0.5rem;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    input[type="url"] {
      border: none;
      padding: 0.5rem;
      border-radius: 0.5rem;
      flex: 1;
      margin-right: 0.5rem;
    }
    button[type="submit"] {
      background-color: #3b82f6;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      cursor: pointer;
    }
    button[type="submit"]:hover {
      background-color: #2563eb;
    }
    footer {
      background-color: #333;
      color: white;
      padding: 1rem 0;
      text-align: center;
      margin-top: auto;
    }
  </style>
</head>
<body>
<header>
  <div class="container">
    <h1>Kamu Japan</h1>
    <nav>
      <ul>
        <li>T2U</li>
        <li><a href="https://kamu.jp/" class="text-blue">Home</a></li>
        <li><a href="https://kamu.jp/t/" class="text-blue">ShortID to Text</a></li>
      </ul>
    </nav>
  </div>
</header>

<section id="apps">
  <div class="container">
    <div class="container bg-gray-100 rounded-lg p-8 flex justify-center">
      <?php
      require_once('../config/db.php');

      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
          $url = $_GET['url'];

          // 9桁のランダムなアルファベットと数字で構成されるIDを生成
          $shortId = uniqid();

          // データベースに保存
          $insertQuery = "INSERT INTO short_urls (url, short_id) VALUES (?, ?)";
          $stmt = $mysqli->prepare($insertQuery);
          $stmt->bind_param('ss', $url, $shortId);
          $stmt->execute();

          // 短縮URLを表示
          $shortUrl = "https://kamu.jp/shortfrom/text/url?q=$shortId";
          echo "<a href='$shortUrl' target='_blank'>生成されたURL: $shortUrl</a>";

          // ステートメントを閉じる
          $stmt->close();
      }

      // MySQLi 接続を閉じる
      $mysqli->close();
      ?>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <p>&copy; 2024 TechCat56. All rights reserved.</p>
  </div>
</footer>
</body>
</html>