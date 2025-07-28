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
<header>
    <ul id="nav">
        <li><a href="login.php">ログイン</a></li>
        <li><a href="sighup.php">会員登録</a></li>
        <li><a href="shuppin.php">出品</a></li>
    </ul>    
</header>

<div class="product-container">
    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=revage;charset=utf8', 'revege_staff', 'password');

    if (isset($_REQUEST['keyword'])) {
        $sql = $pdo->prepare('SELECT * FROM product WHERE name LIKE ?');
        $sql->execute(['%' . $_REQUEST['keyword'] . '%']);
    } else {
        $sql = $pdo->query('SELECT * FROM product');
    }

    echo '<div class="product-row">';
    $count = 0;

    foreach ($sql as $row) {
        $id = $row['id'];
        echo '<div class="product-item">
                <p>
                    <a href="detail.php?id=', $id, '"><img alt="image" src="products/', $row['id'], '.jpg" width="200" height="150"></a>
                </p>
                <p><a href="detail.php?id=', $id, '">', $row['name'], '</a></p>
                <p><a href="detail.php?id=', $id, '">¥', $row['price'], '</a></p>
              </div>';

        $count++;
        if ($count % 3 == 0) {
            echo '</div><div class="product-row">';
        }
    }

    echo '</div>';
    ?>
</div>

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