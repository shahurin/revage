<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>wealthy</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="ここにサイト説明を入れます">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/vegas.min.css">
<link rel="stylesheet" href="css/style.css">
<meta name="google-site-verification" content="MRPhGeR6c_dv9NvU9oK2d3NhQAQp5UjSn2TiC-cO7s8" />
</head>
<body>
<?php
session_start();
var_dump($_SESSION);  // ← ここでも user_id が見える
?>
<header>
    <ul id="nav">
        <li><a href="logout.php">ログアウト</a></li>
        <li><a href="sell.php">出品</a></li>
    </ul>    
</header>


<footer>
    <ul id="footermenu">
        <li><a href="product.php"><p>トップに戻る</p></a></li>
    </ul>
    <div class="small"><a href="product.php"><img src="images/logo2.png" alt="wealthy"></a></div>
        <div class="copy">
            <small>Copyright&copy; wealthy All Rights Reserved.</small>
        </div>
    </div>
</footer>
</body>
</html>