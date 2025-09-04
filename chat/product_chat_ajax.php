<?php
require 'db_connect.php';
session_start();

$product_id = $_GET['product_id'];
$to_user = $_GET['to_user'];
$from_user = $_SESSION['user_id'] ?? 'guest';

// 出品者と購入希望者のやりとりだけを取得
$stmt = $pdo->prepare("
    SELECT c.name, c.id as customer_id, ppc.* 
    FROM product_private_chat ppc
    JOIN customer c ON c.user_id = ppc.from_user_id
    WHERE ppc.product_id = ?
      AND (
            (ppc.from_user_id = ? AND ppc.to_user_id = ?)
         OR (ppc.from_user_id = ? AND ppc.to_user_id = ?)
      )
    ORDER BY ppc.created_at ASC
");
$stmt->execute([$product_id, $from_user, $to_user, $to_user, $from_user]);
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($chats as $c){
    $isMine = ($c['from_user_id']===$from_user);

    echo '<div class="message '.($isMine?'from-user':'to-user').'">';
    // アイコン + 名前
    echo '<div style="font-size:12px; color:#666; margin-bottom:2px;">';
    echo htmlspecialchars($c['name']);
    echo '</div>';
    // メッセージ本文
    echo htmlspecialchars($c['message']);
    // 送信時間
    echo '<div class="time">'.htmlspecialchars($c['created_at']).'</div>';
    echo '</div>';
}
