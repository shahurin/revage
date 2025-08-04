<?php
session_start();
var_dump($_SESSION);  // ← ここでも user_id が見える
$pdo = new PDO('mysql:host=localhost;dbname=revege;charset=utf8','revege_staff','password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user_id = $_POST['user_id'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM customer WHERE user_id=? AND password=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $password]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // user_idをセッションに保存
    $_SESSION['user_id'] = $user['user_id'];

    // 確実にセッションを保存してからリダイレクト
    session_write_close();
    header('Location: revege.php');
    exit;
} else {
    echo 'ユーザーIDまたはパスワードが間違っています';
}
?>
