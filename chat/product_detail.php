<?php
session_start();
require 'db_connect.php';

// ログインチェック
if (!isset($_SESSION['user_id'])) {
    echo "ログインしてください。";
    exit;
}

// 商品IDチェック
if (!isset($_GET['id'])) {
    echo "商品が指定されていません。";
    exit;
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "商品が存在しません。";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($product['name']) ?> - 商品詳細</title>
<style>
    .detail {
        max-width: 600px;
        margin: 20px auto;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 10px;
        background: #fff;
    }
    .detail img {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        margin-bottom: 15px;
    }
</style>
</head>
<body>
    <div class="detail">
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <p><?= nl2br(htmlspecialchars($product['detail'])) ?></p>
        <p><b>¥<?= number_format($product['price']) ?></b></p>
        <p>出品者: <?= htmlspecialchars($product['seller']) ?></p>
        <!-- チャットボタン -->
        <p><a href="product_chat.php?product_id=<?= $product['id'] ?>&to_user=<?= urlencode($product['seller']) ?>">
        この商品の出品者とチャットする
        </a></p>
        <a href="index.php">← 商品一覧に戻る</a>
    </div>
</body>
</html>
