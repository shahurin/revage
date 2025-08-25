<?php
session_start();
require 'db_connect.php';

// ログイン中のユーザーID
$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$sender_id, $receiver_id, $message]);

header("Location: chat.php?with=$receiver_id");
exit;
?>
