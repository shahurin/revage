<?php
require 'db_connect.php';
session_start();

// ログインチェックとパラメータチェック
if (!isset($_SESSION['user_id'], $_GET['product_id'], $_GET['to_user'])) {
    exit;
}

$product_id = $_GET['product_id'];
$to_user = $_GET['to_user'];
$from_user = $_SESSION['user_id'];

// 出品者と購入希望者のやりとりだけを取得（公式ファイルの優れたクエリを維持）
// 日付と時間のフォーマットを追加
$stmt = $pdo->prepare("
    SELECT 
        c.name, 
        ppc.*,
        DATE_FORMAT(ppc.created_at, '%Y年%c月%e日') as chat_date,
        DATE_FORMAT(ppc.created_at, '%H:%i') as chat_time
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

// 新しいデザイン構造でHTMLを生成
$current_date = '';
foreach($chats as $c) {
    // 日付が変わったら区切り線を表示
    if ($current_date !== $c['chat_date']) {
        $current_date = $c['chat_date'];
        echo '<div class="date-separator"><span>' . htmlspecialchars($current_date) . '</span></div>';
    }

    $isMine = ($c['from_user_id'] === $from_user);
    $wrapper_class = $isMine ? 'from-user-wrapper' : 'to-user-wrapper';
    $message_class = $isMine ? 'from-user' : 'to-user';
    
    // メッセージラッパー
    echo '<div class="message-wrapper ' . $wrapper_class . '">';

    // 相手のメッセージの場合、タイムスタンプを左に
    if (!$isMine) {
        echo '<div class="timestamp">' . htmlspecialchars($c['chat_time']) . '</div>';
    }

    // メッセージ本体（名前＋吹き出し）
    echo '<div>';
    if (!$isMine) { // 相手のメッセージの場合のみ名前を表示
        echo '<div class="sender-name">' . htmlspecialchars($c['name']) . '</div>';
    }
    echo '<div class="' . $message_class . '">' . nl2br(htmlspecialchars($c['message'])) . '</div>';
    echo '</div>';

    // 自分のメッセージの場合、タイムスタンプを右に
    if ($isMine) {
        echo '<div class="timestamp">' . htmlspecialchars($c['chat_time']) . '</div>';
    }

    echo '</div>'; // message-wrapper を閉じる
}