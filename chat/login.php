<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログイン - REVEGE</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="ここにサイト説明を入れます">
<!-- 作成したCSSファイルを読み込む -->
<link rel="stylesheet" href="login.css">
</head>
<body>

    <!-- フォーム全体をコンテナで囲む -->
    <div class="login-container">
        <h1>ログイン</h1>

        <form action="login-output.php" method="post">
            
            <!-- ユーザーID入力欄 -->
            <div class="input-group">
                <label for="user_id">ユーザーID</label>
                <input type="text" id="user_id" name="user_id" class="input-field" required>
            </div>

            <!-- パスワード入力欄 -->
            <div class="input-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" class="input-field" required>
            </div>
            
            <!-- ログインボタン -->
            <input type="submit" value="ログイン" class="login-button">
        </form>

        <!-- 新規登録へのリンク -->
        <a href="sighup.php" class="signup-link">新規登録はこちら</a>
    </div>

</body>
</html>