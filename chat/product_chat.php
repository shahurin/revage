<?php
require 'db_connect.php';
session_start();

$product_id = $_GET['product_id'];
$to_user = $_GET['to_user']; // 相手ユーザーID（出品者）
$from_user = $_SESSION['user_id'] ?? 'guest';

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
<title>商品チャット</title>
<link rel="stylesheet" href="chat1.css">
<style>
body,html { margin:0; padding:0; height:100%; }
.chat-container { display:flex; flex-direction:column; height:100vh; }
#chat-box { flex:1; overflow-y:auto; padding:10px; background:#fafafa; }
.message { margin:5px 0; padding:8px 12px; border-radius:12px; max-width:70%; word-wrap:break-word; }
.from-user { background:#dcf8c6; margin-left:auto; text-align:right; }
.to-user   { background:#fff; border:1px solid #ddd; margin-right:auto; text-align:left; }
form { display:flex; padding:10px; border-top:1px solid #ddd; background:#fff; }
form input { flex:1; padding:10px; border:1px solid #ccc; border-radius:20px; }
form button { margin-left:5px; padding:10px 15px; border:none; border-radius:20px; background:#4CAF50; color:white; }
.time { font-size:10px; color:#888; margin-top:2px; }
</style>
</head>
<body>
<div class="chat-container">
    <div id="chat-box"></div>
    <form id="chat-form">
        <input type="text" name="message" id="message" placeholder="メッセージを入力">
        <button type="submit">送信</button>
    </form>
</div>

<script>
const form = document.getElementById('chat-form');
const chatBox = document.getElementById('chat-box');

form.addEventListener('submit', e=>{
    e.preventDefault();
    const message = document.getElementById('message').value;
    if(message==='') return;

    const formData = new FormData();
    formData.append('message', message);

    fetch(`product_chat.php?product_id=<?= $product_id ?>&to_user=<?= urlencode($to_user) ?>`, {
        method:'POST',
        body: formData
    }).then(res=>res.text())
      .then(res=>{
          document.getElementById('message').value='';
          loadMessages();
      });
});

function loadMessages(){
    fetch(`product_chat_ajax.php?product_id=<?= $product_id ?>&to_user=<?= urlencode($to_user) ?>`)
        .then(res=>res.text())
        .then(html=>{
            chatBox.innerHTML = html;
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

setInterval(loadMessages, 3000);
loadMessages();
</script>
</body>
</html>

