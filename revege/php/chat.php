<?php
$filename = 'chat.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = strip_tags($_POST['name'] ?? '名無し');
    $message = strip_tags($_POST['message'] ?? '');

    if ($message) {
        $log = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
        $log[] = ['name' => $name, 'message' => $message, 'time' => time()];
        file_put_contents($filename, json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    exit;
}

if (file_exists($filename)) {
    echo file_get_contents($filename);
} else {
    echo json_encode([]);
}