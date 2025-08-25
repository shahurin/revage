<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>
    <!-- CSSファイルを読み込む -->
    <link rel="stylesheet" href="pf.css">
</head>
<body>

    <div class="screen-container">
        <!-- メインコンテンツ -->
        <main>
            <!-- プロフィールヘッダー -->
            <header class="profile-header">
                <div class="profile-picture-container">
                    <!-- ★ id="profile-picture" を追加 -->
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&h=200&fit=crop&q=80" alt="田中和樹のプロフィール写真" class="profile-picture" id="profile-picture">
                    <div class="edit-icon-container">
                        <svg class="edit-icon" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>
                    </div>
                </div>
                <!-- ★ id="profile-name" を追加 -->
                <h1 id="profile-name">田中和樹</h1>
                <!-- ★ id="profile-email" を追加 -->
                <p class="email" id="profile-email">kazuki.tanaka@example.com</p>
                <button class="edit-profile-button" onclick="location.href='pf2.php'">プロフィールを編集</button>
            </header>

            <!-- アカウント設定 -->
            <section class="settings-section">
                <h2>アカウント設定</h2>
                <ul class="settings-list">
                    <li>
                        <a href="#" class="settings-item">
                            <div class="setting-content">
                                <svg class="setting-icon" viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"></path></svg>
                                <span>通知</span>
                            </div>
                            <svg class="arrow-icon" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="settings-item">
                            <div class="setting-content">
                                <svg class="setting-icon" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"></path></svg>
                                <span>プライバシー</span>
                            </div>
                            <svg class="arrow-icon" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="settings-item">
                            <div class="setting-content">
                                <svg class="setting-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.48-1.17 4.68-3.1 6.07z"></path></svg>
                                <span>言語</span>
                            </div>
                            <svg class="arrow-icon" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="settings-item">
                            <div class="setting-content">
                                <svg class="setting-icon" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"></path></svg>
                                <span>支払い方法</span>
                            </div>
                            <svg class="arrow-icon" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path></svg>
                        </a>
                    </li>
                     <li>
                        <a href="#" class="settings-item">
                            <div class="setting-content">
                                <svg class="setting-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"></path></svg>
                                <span>ヘルプとサポート</span>
                            </div>
                            <svg class="arrow-icon" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path></svg>
                        </a>
                    </li>
                </ul>
            </section>
        </main>

        <!-- 下部ナビゲーション (ここから修正) -->
        <nav class="bottom-nav">
            <a href="revege.php" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path></svg>
                <span>ホーム</span>
            </a>
            <a href="search.php" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>
                <span>検索</span>
            </a>
            <a href="cart.php" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                <span>カート</span>
            </a>
            <a href="pf.php" class="nav-item active"> <!-- 現在のページなので active クラスを付与 -->
                <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path><path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path></svg>
                <span>プロフィール</span>
            </a>
        </nav>
        <!-- (ここまで修正) -->
    </div>
    
    <!-- ★ ここからJavaScriptを追加 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 表示を更新するための要素を取得
            const profilePicture = document.getElementById('profile-picture');
            const profileName = document.getElementById('profile-name');
            const profileEmail = document.getElementById('profile-email');

            // localStorageから保存されたデータを読み込む関数
            function loadProfile() {
                const savedProfile = localStorage.getItem('userProfile');

                if (savedProfile) {
                    const userProfile = JSON.parse(savedProfile);
                    
                    // 各要素の表示を更新
                    profilePicture.src = userProfile.picture || 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&h=200&fit=crop&q=80'; // データがなければ初期画像
                    profileName.textContent = userProfile.name || '名前';
                    profileEmail.textContent = userProfile.email || 'メールアドレス';
                }
            }

            // ページが読み込まれたら、保存されたデータを反映する
            loadProfile();
        });
    </script>

</body>
</html>