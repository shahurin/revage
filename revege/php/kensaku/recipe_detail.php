<?php
// データベース接続
$db = new PDO('mysql:host=localhost;dbname=food_db;charset=utf8', 'username', 'password');

if (!isset($_GET['id'])) {
    header("Location: recipe_suggestion.php");
    exit;
}

$recipeId = $_GET['id'];

// レシピ基本情報を取得
$stmt = $db->prepare("SELECT * FROM recipes WHERE id = :id");
$stmt->execute([':id' => $recipeId]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    header("Location: recipe_suggestion.php");
    exit;
}

// レシピの材料を取得
$stmt = $db->prepare("SELECT p.name, ri.quantity 
                      FROM recipe_ingredients ri
                      JOIN products p ON ri.product_id = p.id
                      WHERE ri.recipe_id = :recipeId");
$stmt->execute([':recipeId' => $recipeId]);
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($recipe['name']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($recipe['name']) ?></h1>
    
    <h2>材料</h2>
    <ul>
        <?php foreach ($ingredients as $ingredient): ?>
            <li><?= htmlspecialchars($ingredient['name']) ?> - <?= htmlspecialchars($ingredient['quantity']) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <h2>作り方</h2>
    <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>
    
    <p>調理時間: <?= htmlspecialchars($recipe['cooking_time']) ?>分</p>
    
    <a href="recipe_suggestion.php">戻る</a>
</body>
</html>