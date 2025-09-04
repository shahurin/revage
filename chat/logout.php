<?php
// セッション開始（必須）
session_start();

// ログイン中かどうか確認
if (isset($_SESSION['customer'])) {
    // セッション変数をすべて削除
    $_SESSION = array();

    // クッキーでセッションIDが残っている場合は削除
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), 
            '', 
            time() - 42000, 
            $params["path"], 
            $params["domain"], 
            $params["secure"], 
            $params["httponly"]
        );
    }

    // セッションを完全に破棄
    session_destroy();

    // ログインページにリダイレクト
    header("Location: login.php");
    exit();
} else {
    // すでにログアウトしている場合のメッセージ
    echo 'すでにサインアウトしています。';
}
?>
