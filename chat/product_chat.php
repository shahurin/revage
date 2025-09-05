<?php
require 'db_connect.php';
session_start();

// ログインチェック
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// パラメータチェック
if (!isset($_GET['product_id']) || !isset($_GET['to_user'])) {
    header('Location: revege.php');
    exit;
}

$product_id = $_GET['product_id'];
$to_user = $_GET['to_user']; // 相手ユーザーID（出品者）
$from_user = $_SESSION['user_id'];

// 新規メッセージ送信（Ajax用）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'] ?? '';
    if ($message !== '') {
        $stmt = $pdo->prepare("
            INSERT INTO product_private_chat (product_id, from_user_id, to_user_id, message) 
            VALUES (?,?,?,?)
        ");
        $stmt->execute([$product_id, $from_user, $to_user, $message]);
    }
    exit('OK');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>チャット</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<!-- 共通CSS（アプリ風の基本スタイル用） -->
<link rel="stylesheet" href="revege.css"> 
<!-- 更新したチャット専用CSS -->
<link rel="stylesheet" href="chat.css">
</head>
<body>

<div class="app-container">
    <!-- ヘッダー -->
    <header class="page-header">
        <a href="product_detail.php?id=<?= htmlspecialchars($product_id) ?>" class="back-button">
            <span class="material-icons-outlined">arrow_back_ios</span>
        </a>
        <h1><?= htmlspecialchars($to_user) ?></h1>
    </header>

    <div class="chat-container">
        <!-- チャットボックス -->
        <div id="chat-box"></div>
    </div>
    
    <!-- メッセージ入力フォーム -->
    <form id="chat-form">
        <input type="text" id="message-input" placeholder="メッセージを入力..." autocomplete="off">
        <button type="submit">
            <span class="material-icons-outlined">send</span>
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('chat-form');
    const input = document.getElementById('message-input');
    const chatBox = document.getElementById('chat-box');
    const productId = '<?= $product_id ?>';
    const toUser = '<?= urlencode($to_user) ?>';

    // フォーム送信処理
    form.addEventListener('submit', e => {
        e.preventDefault();
        const message = input.value.trim();
        if (message === '') return;
        
        const formData = new FormData();
        formData.append('message', message);

        input.value = ''; // 先にクリアしてUX向上

        fetch(`product_chat.php?product_id=${productId}&to_user=${toUser}`, {
            method: 'POST',
            body: formData
        }).then(res => {
            if (res.ok) {
                loadMessages(true); // 即時更新（自分が送信したフラグを立てる）
            }
        });
    });

    // メッセージを非同期で読み込む関数
    function loadMessages(forceScroll = false) {
        fetch(`product_chat_ajax.php?product_id=${productId}&to_user=${toUser}`)
            .then(res => res.text())
            .then(html => {
                const isScrolledToBottom = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 5;
                
                chatBox.innerHTML = html;

                // 常に一番下にスクロールするか、ユーザーが元々一番下にいた場合のみスクロール
                if(forceScroll || isScrolledToBottom) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });
    }

    // 3秒ごとにメッセージを定期更新
    setInterval(() => loadMessages(false), 3000);
    
    // ページ読み込み時に初回読み込み
    loadMessages(true);
});
</script>
</body>
</html>