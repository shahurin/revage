<?php
// データベース接続
$db = new PDO('mysql:host=localhost;dbname=food_db;charset=utf8', 'username', 'password');

// 検索処理
if (isset($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    
    $sql = "SELECT * FROM products WHERE name LIKE :searchTerm";
    $params = [':searchTerm' => $searchTerm];
    
    if (!empty($category)) {
        $sql .= " AND category = :category";
        $params[':category'] = $category;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>商品検索</title>
</head>
<body>
    <h1>商品検索</h1>
    <form method="GET">
        <input type="text" name="search" placeholder="商品名で検索" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <select name="category">
            <option value="">すべてのカテゴリ</option>
            <option value="野菜">野菜</option>
            <option value="肉">肉</option>
            <option value="魚">魚</option>
            <option value="調味料">調味料</option>
        </select>
        <button type="submit">検索</button>
    </form>
    
    <?php if (isset($products)): ?>
        <h2>検索結果</h2>
        <table border="1">
            <tr>
                <th>商品名</th>
                <th>カテゴリ</th>
                <th>価格</th>
                <th>在庫</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?>円</td>
                    <td><?= htmlspecialchars($product['stock']) ?>個</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>