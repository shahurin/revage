<?php
session_start();
require 'db_connect.php';

// ログインチェック
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 商品IDチェック
if (!isset($_GET['id'])) {
    // IDがなければ一覧ページに戻す
    header('Location: revege.php');
    exit;
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    // 商品が存在しなければ一覧ページに戻す
    header('Location: revege.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($product['name']) ?> - 商品詳細</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Google Fonts (Material Icons) -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<!-- 共通CSS -->
<link rel="stylesheet" href="revege.css">
<!-- 詳細ページ専用CSS -->
<link rel="stylesheet" href="product-detail.css">
</head>
<body>

<div class="app-container">
    
    <!-- ヘッダー -->
    <header class="page-header">
        <a href="revege.php" class="back-button">
            <span class="material-icons-outlined">arrow_back_ios</span>
        </a>
        <h1>商品詳細</h1>
    </header>

    <!-- メインコンテンツ -->
    <main class="detail-content">
        <!-- 商品画像 -->
        <div class="product-image-container">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <!-- 商品情報 -->
        <div class="product-info">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <div class="price">¥<?= number_format($product['price']) ?></div>
            <p class="description"><?= nl2br(htmlspecialchars($product['detail'])) ?></p>
        </div>

        <!-- 出品者情報 -->
        <div class="seller-info">
            <div class="avatar"></div> <!-- プロフィール画像（ダミー） -->
            <div class="seller-name">
                <span>出品者</span>
                <strong><?= htmlspecialchars($product['seller']) ?></strong>
            </div>
        </div>
    </main>

    <!-- アクションフッター -->
    <div class="action-footer">
        <a href="product_chat.php?product_id=<?= $product['id'] ?>&to_user=<?= urlencode($product['seller']) ?>" class="chat-button">
            出品者とチャットする
        </a>
    </div>

</div>

</body>
</html>