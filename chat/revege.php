<?php
session_start();
require 'db_connect.php';

// ログインチェック
if (!isset($_SESSION['user_id'])) {
    // ログインページへリダイレクト
    header('Location: login.php');
    exit;
}

// ページネーション設定
$page = $_GET['page'] ?? 1;
$page = max($page, 1);
$limit = 10; // 1ページあたりの表示件数を10件に変更
$offset = ($page - 1) * $limit;

// 商品取得
$sql = "SELECT * FROM product ORDER BY id DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 総件数
$total_sql = "SELECT COUNT(*) FROM product";
$total = $pdo->query($total_sql)->fetchColumn();
$total_pages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>REVEGE - ホーム</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="農家と消費者を直接つなぐ新鮮野菜のフリマプラットフォーム">
<!-- Google Fonts (Material Icons) -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<!-- 作成したCSSファイル -->
<link rel="stylesheet" href="revege.css">
</head>
<body>

<div class="app-container">
    
    <!-- ヘッダー -->
    <header class="app-header">
        <div class="logo">REVEGE</div>
        <div class="search-bar">
            <span class="material-icons-outlined">search</span>
            <input type="search" placeholder="野菜や果物を探す">
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main>
        <div class="section-header">
            <h1>新着のやさい</h1>
            <a href="#">すべて見る</a>
        </div>

        <!-- 商品グリッド -->
        <div class="product-grid">
            <?php foreach ($products as $p): ?>
                <a href="product_detail.php?id=<?= $p['id'] ?>" class="product-card-link">
                    <div class="product-card">
                        <div class="image-container">
                            <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                        </div>
                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="price">¥<?= number_format($p['price']) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- ページネーション -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i==$page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </main>

    <!-- 下部ナビゲーション -->
    <nav class="bottom-nav">
        <a href="revege.php" class="nav-item active">
            <span class="material-icons-outlined">home</span>
            <span>ホーム</span>
        </a>
        <a href="#" class="nav-item"> <!-- search.phpなどに変更 -->
            <span class="material-icons-outlined">search</span>
            <span>検索</span>
        </a>
        <a href="sell.php" class="nav-item">
            <span class="material-icons-outlined">add_circle_outline</span>
            <span>出品</span>
        </a>

        <a href="chat.php" class="nav-item">
            <span class="material-icons-outlined">chat_bubble_outline</span>
            <span>チャット</span>
            </a>

        <a href="pf.php" class="nav-item">
            <span class="material-icons-outlined">person_outline</span>
            <span>プロフィール</span>
        </a>
    </nav>

</div>

</body>
</html>