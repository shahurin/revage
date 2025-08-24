<?php
// sell2.php
session_start();
require_once 'db_connect.php'; // ←ここでPDO接続を読み込む

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 入力データ
        $name   = $_POST['name'] ?? '';
        $price  = $_POST['price'] ?? 0;
        $detail = $_POST['detail'] ?? '';
        $seller = $_SESSION['user_id'] ?? 'guest'; // ログインしている想定

        if ($name === '' || $price === '' || $detail === '') {
            throw new Exception('未入力の項目があります');
        }

        // 商品登録
        $stmt = $pdo->prepare("INSERT INTO product (name, detail, price, seller, image) VALUES (?, ?, ?, ?, '')");
        $stmt->execute([$name, $detail, $price, $seller]);
        $productId = $pdo->lastInsertId();

        // 画像アップロード処理
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = __DIR__ . "/uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            foreach ($_FILES['images']['tmp_name'] as $i => $tmpName) {
                if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;

                $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                $filename = uniqid("img_") . "." . $ext;
                $dest = $uploadDir . $filename;

                if (move_uploaded_file($tmpName, $dest)) {
                    // DB登録
                    $stmt = $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$productId, "uploads/" . $filename]);
                }
            }

            // 最初の画像をメイン画像として product.image に保存
            $stmt = $pdo->prepare("UPDATE product SET image = (SELECT image_path FROM product_images WHERE product_id=? LIMIT 1) WHERE id=?");
            $stmt->execute([$productId, $productId]);
        }

        echo "商品を登録しました！";

    } catch (Exception $e) {
        echo "エラー: " . $e->getMessage();
    }
}