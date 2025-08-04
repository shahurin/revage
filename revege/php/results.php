<!DOCTYPE html>
<html>
<head>
    <title>検索結果</title>
</head>
<body>
    <h1>"<?= htmlspecialchars($searchTerm) ?>" の検索結果</h1>
    
    <?php if (!empty($products)): ?>
        <ul>
            <?php foreach ($products as $product): ?>
                <li>
                    <?= htmlspecialchars($product['name']) ?> -
                    ¥<?= number_format($product['price']) ?> -
                    <?= htmlspecialchars($product['category']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>該当する商品が見つかりませんでした</p>
    <?php endif; ?>
    
    <a href="?action=home">新しい検索</a>
</body>
</html>