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
<style>
    .grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr); /* 5列 */
        gap: 20px;
        margin: 20px;
    }
    .item {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .item:hover {
        transform: scale(1.05);
    }
    .item a {
        display: block;
        color: inherit;
        text-decoration: none;
    }
    .item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
    }
    .pagination {
        margin: 20px;
        text-align: center;
    }
    .pagination a {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-decoration: none;
    }
    .pagination a.active {
        background: #333;
        color: #fff;
    }
</style>
</head>
<body>
<?php
session_start();
require 'db_connect.php';

// ログインチェック
if (!isset($_SESSION['user_id'])) {
    echo "<p>ログインしてください。</p>";
    exit;
}

// ページネーション設定
$page = $_GET['page'] ?? 1;
$page = max($page, 1);
$limit = 20; // 1ページ20件 (4行×5列)
$offset = ($page - 1) * $limit;

// 商品取得
$sql = "SELECT * FROM product LIMIT :limit OFFSET :offset";
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

<header>
    <ul id="nav">
        <li><a href="logout.php">ログアウト</a></li>
        <li><a href="sell.php">出品</a></li>
    </ul>    
</header>

<h1 style="text-align:center;">商品一覧</h1>

<div class="grid">
<?php foreach ($products as $p): ?>
    <div class="item">
        <a href="product_detail.php?id=<?= $p['id'] ?>">
            <img src="<?= htmlspecialchars($p['image']) ?>" alt="">
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            <p><b>¥<?= number_format($p['price']) ?></b></p>
        </a>
    </div>
<?php endforeach; ?>
</div>

<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i==$page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>

</body>
</html>
