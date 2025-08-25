<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>商品登録</title>
<link rel="stylesheet" href="sell.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body>

<div class="mobile-container">
    <header class="header"><h1>商品登録</h1></header>

    <main class="main-content">
        <!-- メイン画像 -->
        <div class="image-carousel">
            <img src="images/placeholder.png" alt="メインの商品画像" id="main-preview">
        </div>

        <!-- サムネイルギャラリー -->
        <div class="thumbnail-gallery" id="thumbnail-gallery">
            <div class="thumbnail-container"><span class="material-icons-outlined">add_a_photo</span></div>
            <div class="thumbnail-container"><span class="material-icons-outlined">add_a_photo</span></div>
            <div class="thumbnail-container"><span class="material-icons-outlined">add_a_photo</span></div>
            <div class="thumbnail-container"><span class="material-icons-outlined">add_a_photo</span></div>
        </div>

        <!-- 商品フォーム -->
        <form class="product-form" id="product-form">
            <input type="file" id="image-upload-input" multiple accept="image/*" style="display:none">
            <div class="form-row">
                <input type="text" name="name" class="form-input" placeholder="商品名" required>
            </div>
            <div class="form-row">
                <input type="number" name="price" class="form-input" placeholder="価格" min="0" required>
            </div>
            <div class="form-row">
                <textarea name="detail" class="form-input" placeholder="商品の詳細" rows="4" required></textarea>
            </div>
            <div class="form-actions">
                <button type="button" id="clear-button" class="btn btn-cancel">クリア</button>
                <button type="submit" class="btn btn-submit">登録</button>
            </div>
        </form>
    </main>
    <nav class="bottom-nav">
        <a href="revege.php" class="nav-item active"><span class="material-icons-outlined">home</span><span>ホーム</span></a>
        <a href="search.php" class="nav-item"><span class="material-icons-outlined">search</span><span>検索</span></a>
        <a href="cart.php" class="nav-item"><span class="material-icons-outlined">shopping_cart</span><span>カート</span></a>
        <a href="pf.php" class="nav-item"><span class="material-icons-outlined">history</span><span>プロフィール</span></a>
    </nav>
</div>

<script>
const MAX_FILES = 4;
const fileInput = document.getElementById('image-upload-input');
const mainPreview = document.getElementById('main-preview');
const thumbnailContainers = Array.from(document.querySelectorAll('.thumbnail-container'));
const form = document.getElementById('product-form');
let selectedFiles = [];

// ファイル選択
fileInput.addEventListener('change', () => {
    const files = Array.from(fileInput.files);
    files.forEach(file => {
        if(selectedFiles.length < MAX_FILES){
            selectedFiles.push(file);
        }
    });
    if(selectedFiles.length > MAX_FILES) selectedFiles = selectedFiles.slice(0, MAX_FILES);
    updatePreviews(selectedFiles);
    fileInput.value = '';
});

// サムネクリックでメイン画像切替
thumbnailContainers.forEach(container => {
    container.addEventListener('click', () => {
        const img = container.querySelector('img');
        if(img){
            thumbnailContainers.forEach(c => c.classList.remove('active'));
            container.classList.add('active');
            mainPreview.src = img.src;
        } else {
            fileInput.click();
        }
    });
});

// クリアボタン
document.getElementById('clear-button').addEventListener('click', () => {
    if(!confirm('選択した画像をすべてクリアしますか？')) return;
    selectedFiles = [];
    updatePreviews([]);
});

// プレビュー更新関数
function updatePreviews(files){
    thumbnailContainers.forEach(c => {
        c.innerHTML = '<span class="material-icons-outlined">add_a_photo</span>';
        c.classList.remove('active');
    });

    files.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const container = thumbnailContainers[i];
            container.innerHTML = `<img src="${e.target.result}" alt="サムネイル ${i+1}">`;
            if(i===0){
                container.classList.add('active');
                mainPreview.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    });
}

// Ajax送信
form.addEventListener('submit', e => {
    e.preventDefault();
    if(selectedFiles.length === 0){
        alert('画像を1枚以上選択してください');
        return;
    }

    const formData = new FormData(form);
    selectedFiles.forEach(file => formData.append('images[]', file));

    fetch('sell2.php', { method: 'POST', body: formData })
        .then(res => res.text())
        .then(text => alert(text))
        .catch(err => console.error(err));
});
</script>

</body>
</html>
