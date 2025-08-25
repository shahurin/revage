<?php
require 'db_connect.php';
session_start();

$product_id = $_GET['product_id'];
$to_user = $_GET['to_user'];
$from_user = $_SESSION['user_id'] ?? 'guest';

// 新規メッセージ送信（Ajax用）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'] ?? '';
    if ($message !== '') {
        $stmt = $pdo->prepare("INSERT INTO product_private_chat (product_id, from_user_id, to_user_id, message) VALUES (?,?,?,?)");
        $stmt->execute([$product_id, $from_user, $to_user, $message]);
    }
    exit('OK');
}

// メッセージ一覧取得
$stmt = $pdo->prepare("SELECT * FROM product_private_chat WHERE product_id=? ORDER BY created_at ASC");
$stmt->execute([$product_id]);
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="chat.css">
<meta charset="UTF-8">
<title>商品チャット</title>
<style>
.chat-container { width: 360px; margin: 0 auto; border:1px solid #ccc; padding:10px; }
.message { margin:5px 0; padding:5px 10px; border-radius:10px; max-width:70%; }
.from-user { background-color:#e0ffe0; text-align:right; margin-left:auto; }
.to-user   { background-color:#f0f0f0; text-align:left; margin-right:auto; }
#chat-box { height:300px; overflow-y:auto; border:1px solid #ccc; padding:5px; margin-bottom:10px; }
</style>
</head>
<body>

<h2>商品チャット</h2>
<div id="chat-box">
<?php foreach($chats as $c): ?>
    <div class="message-wrapper <?= ($c['from_user_id']===$from_user)?'from-user-wrapper':'to-user-wrapper' ?>">
        <div class="message <?= ($c['from_user_id']===$from_user)?'from-user':'to-user' ?>">
            <?= htmlspecialchars($c['message']) ?>
        </div>
    </div>
<?php endforeach; ?>
</div>

<form id="chat-form">
    <input type="text" name="message" id="message" placeholder="メッセージを入力" style="width:70%">
    <button type="submit">送信</button>
</form>

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

// メッセージ更新（Ajax）
function loadMessages(){
    fetch(`product_chat_ajax.php?product_id=<?= $product_id ?>`)
        .then(res=>res.text())
        .then(html=>{
            chatBox.innerHTML = html;
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

// 3秒ごとに更新
setInterval(loadMessages,3000);
</script>

</body>
</html>
