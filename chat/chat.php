<?php
require 'db_connect.php';
session_start();

$seller_id = $_SESSION['user_id'] ?? null;
if (!$seller_id) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("
    SELECT 
        pr.id AS product_id,
        pr.name AS product_name,
        c.user_id AS from_user_id,
        c.name AS from_user_name,
        MAX(ppc.created_at) AS last_message_time,
        SUBSTRING_INDEX(
            MAX(CONCAT(ppc.created_at, '||', ppc.message)), 
            '||', -1
        ) AS last_message
    FROM product_private_chat ppc
    JOIN product pr ON pr.id = ppc.product_id
    JOIN customer c ON c.user_id = ppc.from_user_id
    WHERE ppc.to_user_id = ?
    GROUP BY pr.id, pr.name, c.user_id, c.name
    ORDER BY last_message_time DESC
");
$stmt->execute([$seller_id]);
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>届いたメッセージ一覧</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>届いたメッセージ一覧</h2>

<?php if (empty($chats)): ?>
    <p>届いているメッセージはありません。</p>
<?php else: ?>
    <ul>
    <?php foreach ($chats as $c): ?>
        <li>
            <strong><?php echo htmlspecialchars($c['product_name']); ?></strong><br>
            相手: <?php echo htmlspecialchars($c['from_user_name']); ?><br>
            最新メッセージ: <?php echo htmlspecialchars($c['last_message']); ?><br>
            <small><?php echo htmlspecialchars($c['last_message_time']); ?></small><br>
            <a href="product_chat.php?product_id=<?php echo $c['product_id']; ?>&to_user=<?php echo $c['from_user_id']; ?>">
                このチャットを見る
            </a>
        </li>
        <hr>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
0
