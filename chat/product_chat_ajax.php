<?php
require 'db_connect.php';
session_start();

$product_id = $_GET['product_id'];
$from_user = $_SESSION['user_id'] ?? 'guest';

$stmt = $pdo->prepare("SELECT * FROM product_private_chat WHERE product_id=? ORDER BY created_at ASC");
$stmt->execute([$product_id]);
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($chats as $c){
    $cls = ($c['from_user_id']===$from_user)?'from-user':'to-user';
    echo '<div class="message '.$cls.'">'
        .htmlspecialchars($c['from_user_id']).': '.htmlspecialchars($c['message'])
        .'</div>';
}
