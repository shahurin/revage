<?php
session_start();
require 'db_connect.php';

$user_id = $_SESSION['user_id'];
$with_id = $_GET['with'];

// 双方のメッセージを取得
$sql = "SELECT * FROM messages 
        WHERE (sender_id = ? AND receiver_id = ?)
           OR (sender_id = ? AND receiver_id = ?)
        ORDER BY created_at ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $with_id, $with_id, $user_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>チャット</title>
</head>
<body>
<h2>チャット</h2>
<div style="border:1px solid #ccc; height:300px; overflow-y:scroll;">
    <?php foreach($messages as $msg): ?>
        <p><b><?= ($msg['sender_id']==$user_id ? "自分" : "相手") ?>:</b>
        <?= htmlspecialchars($msg['message']) ?> (<?= $msg['created_at'] ?>)</p>
    <?php endforeach; ?>
</div>

<form action="chat_send.php" method="post">
    <input type="hidden" name="receiver_id" value="<?= $with_id ?>">
    <input type="text" name="message" required>
    <button type="submit">送信</button>
</form>
</body>
</html>
