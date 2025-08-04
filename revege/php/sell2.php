<?php
session_start(); // セッション開始
var_dump($_SESSION);  // ← ここでも user_id が見える

ini_set('display_errors', 1);
error_reporting(E_ALL);

$uploadDir = __DIR__ . '/uploads/';
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

// ログイン中の user_id を seller として使用
$seller = $_SESSION['user_id'] ?? 'guest';

// フォームデータ取得
$name   = $_POST['name'] ?? '';
$detail = $_POST['detail'] ?? '';
$price  = $_POST['price'] ?? '';
$imagePath = '';

if (!empty($_FILES['image']['name'])) {
    $tmpName  = $_FILES['image']['tmp_name'];
    $fileName = basename($_FILES['image']['name']);
    $target   = $uploadDir . $fileName;
    if (move_uploaded_file($tmpName, $target)) {
        $imagePath = 'uploads/' . $fileName;
    } else {
        echo "画像のアップロードに失敗しました。";
    }
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=revege;charset=utf8', 'revege_staff', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO product (name, detail, price, seller, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $detail, $price, $seller, $imagePath]);

    echo "出品が完了しました！<br>";
    echo "<a href='product_list.php'>商品一覧を見る</a>";

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>
