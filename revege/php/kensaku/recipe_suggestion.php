<?php
// データベース接続
try {
    // データベース接続設定
    $host = 'localhost';
    $dbname = 'food_db';
    $username = 'your_actual_username'; // 実際のデータベースユーザー名
    $password = 'your_actual_password'; // 実際のデータベースパスワード
    
    // PDO接続オプション
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // エラー時に例外をスロー
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // デフォルトで連想配列で取得
        PDO::ATTR_EMULATE_PREPARES => false, // プリペアドステートメントをエミュレートしない
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4" // 文字コード設定
    ];
    
    // PDO接続
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
    
} catch (PDOException $e) {
    // エラー処理
    die("データベース接続に失敗しました: " . $e->getMessage());
}
?>

// ユーザーID (実際のアプリではセッションなどから取得)
$userId = 1;

// ユーザーの保有食材を取得
$stmt = $db->prepare("SELECT p.id, p.name, p.category, ui.quantity 
                      FROM user_inventory ui
                      JOIN products p ON ui.product_id = p.id
                      WHERE ui.user_id = :userId");
$stmt->execute([':userId' => $userId]);
$userInventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

// レシピ提案
$suggestedRecipes = [];
if (!empty($userInventory)) {
    // 保有食材のIDを取得
    $inventoryProductIds = array_column($userInventory, 'id');
    
    // 保有食材で作れるレシピを検索
    $placeholders = implode(',', array_fill(0, count($inventoryProductIds), '?'));
    
    $sql = "SELECT r.id, r.name, COUNT(ri.product_id) AS matched_ingredients
            FROM recipes r
            JOIN recipe_ingredients ri ON r.id = ri.recipe_id
            WHERE ri.product_id IN ($placeholders)
            GROUP BY r.id
            HAVING matched_ingredients > 0
            ORDER BY matched_ingredients DESC
            LIMIT 5";
    
    $stmt = $db->prepare($sql);
    $stmt->execute($inventoryProductIds);
    $suggestedRecipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>レシピ提案</title>
</head>
<body>
    <h1>保有食材に基づくレシピ提案</h1>
    
    <h2>現在の保有食材</h2>
    <ul>
        <?php foreach ($userInventory as $item): ?>
            <li><?= htmlspecialchars($item['name']) ?> (<?= htmlspecialchars($item['quantity']) ?>個)</li>
        <?php endforeach; ?>
    </ul>
    
    <h2>おすすめレシピ</h2>
    <?php if (!empty($suggestedRecipes)): ?>
        <ul>
            <?php foreach ($suggestedRecipes as $recipe): ?>
                <li>
                    <h3><?= htmlspecialchars($recipe['name']) ?></h3>
                    <p>一致食材: <?= htmlspecialchars($recipe['matched_ingredients']) ?>種類</p>
                    <a href="recipe_detail.php?id=<?= $recipe['id'] ?>">詳細を見る</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>保有食材に基づくレシピが見つかりませんでした。</p>
    <?php endif; ?>
</body>
</html>