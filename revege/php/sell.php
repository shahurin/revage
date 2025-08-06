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
        <header class="header">
            <h1>商品登録</h1>
        </header>

        <main class="main-content">
            <div class="image-carousel">
                <img src="images/placeholder.png" alt="メインの商品画像" id="main-preview">
                <div class="carousel-dots">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>

            <div class="thumbnail-gallery" id="thumbnail-gallery">
                <div class="thumbnail-container"><span class="material-icons-outlined">add_a_photo</span></div>
                <div class="thumbnail-container"><span class="material-icons-outlined">add_a_photo</span></div>
                <div class="thumbnail-container"><span class="material-icons-outlined">add_a_photo</span></div>
                <div class="thumbnail-container"><span class="material-icons-outlined">add_a_photo</span></div>
            </div>

            <form class="product-form" action="sell2.php" method="post" enctype="multipart/form-data">
                <input type="file" id="image-upload-input" name="images[]" multiple accept="image/*">
                
                <p style="text-align: center; color: #6c757d; margin: -5px 0 15px;">写真枠をタップして画像を選択 (最大4枚)</p>

                <div class="form-row">
                    <input type="text" name="name" class="form-input half-width" placeholder="商品名">
                    <input type="text" name="category" class="form-input half-width" placeholder="カテゴリ">
                </div>
                <div class="form-row with-icon">
                    <select name="size" class="form-input">
                        <option disabled>サイズを選択</option>
                        <option selected>M</option>
                        <option>S</option>
                        <option>L</option>
                    </select>
                    <div class="select-arrows">
                        <span class="material-icons-outlined">arrow_drop_up</span>
                        <span class="material-icons-outlined">arrow_drop_down</span>
                    </div>
                </div>
                 <div class="form-row with-icon">
                    <input type="text" name="price" class="form-input" placeholder="価格">
                     <div class="select-arrows">
                        <span class="material-icons-outlined">arrow_drop_up</span>
                        <span class="material-icons-outlined">arrow_drop_down</span>
                    </div>
                </div>
                <div class="form-row">
                    <textarea name="detail" class="form-input" placeholder="商品の詳細" rows="4"></textarea>
                </div>

                <div class="form-actions">
                    <!--ボタンの文言をクリアに変更IDを追加 -->
                    <button type="button" id="clear-button" class="btn btn-cancel">クリア</button>
                    <button type="submit" class="btn btn-submit">登録</button>
                </div>
            </form>
        </main>

        <nav class="bottom-nav">
            <a href="#" class="nav-item active"><span class="material-icons-outlined">home</span><span>ホーム</span></a>
            <a href="#" class="nav-item"><span class="material-icons-outlined">search</span><span>検索</span></a>
            <a href="#" class="nav-item"><span class="material-icons-outlined">shopping_cart</span><span>カート</span></a>
            <a href="#" class="nav-item"><span class="material-icons-outlined">history</span><span>プロフィール</span></a>
        </nav>
    </div>

    <script>
        const MAX_FILES = 4;
        const fileInput = document.getElementById('image-upload-input');
        const mainPreview = document.getElementById('main-preview');
        const thumbnailGallery = document.getElementById('thumbnail-gallery');
        const thumbnailContainers = Array.from(document.querySelectorAll('.thumbnail-container'));
        //クリアボタンの要素を取得
        const clearButton = document.getElementById('clear-button');

        let managedFiles = [];


        thumbnailGallery.addEventListener('click', (event) => {
            const container = event.target.closest('.thumbnail-container');
            if (!container) return;

            if (container.querySelector('img')) {
                switchMainPreview(container);
            } else {
                fileInput.click();
            }
        });

        fileInput.addEventListener('change', (event) => {
            const newFiles = Array.from(event.target.files);
            managedFiles = managedFiles.concat(newFiles);

            if (managedFiles.length > MAX_FILES) {
                managedFiles = managedFiles.slice(0, MAX_FILES);
                alert(`画像は合計${MAX_FILES}枚までです。超過分は追加されませんでした。`);
            }
            
            updateFileInputAndPreviews();
            fileInput.value = '';
        });

        clearButton.addEventListener('click', () => {
            // 確認ダイアログを表示
            if (managedFiles.length > 0 && confirm('選択した画像をすべてクリアしますか？')) {
                managedFiles = []; // 管理しているファイル配列を空にする
                updateFileInputAndPreviews(); // プレビューとフォーム入力を更新
            } else if (managedFiles.length === 0) {
                // 画像が選択されていない場合は何もしない
            }
        });

        // --- 関数---

        function updateFileInputAndPreviews() {
            const dataTransfer = new DataTransfer();
            managedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;

            thumbnailContainers.forEach(c => {
                c.innerHTML = '<span class="material-icons-outlined">add_a_photo</span>';
                c.classList.remove('active');
            });
            
            managedFiles.forEach((file, index) => {
                const container = thumbnailContainers[index];
                const reader = new FileReader();
                reader.onload = (e) => {
                    container.innerHTML = `<img src="${e.target.result}" alt="サムネイル ${index + 1}">`;
                };
                reader.readAsDataURL(file);
            });
            
            updateMainPreview();
        }

        function updateMainPreview() {
            const activeContainer = thumbnailGallery.querySelector('.thumbnail-container.active');
            
            if (!activeContainer && managedFiles.length > 0) {
                thumbnailContainers[0].classList.add('active');
            }

            const currentActive = thumbnailGallery.querySelector('.thumbnail-container.active');
            if (currentActive && currentActive.querySelector('img')) {
                mainPreview.src = currentActive.querySelector('img').src;
            } else if (managedFiles.length > 0) {
                mainPreview.src = URL.createObjectURL(managedFiles[0]);
                thumbnailContainers[0].classList.add('active');
            } else {
                mainPreview.src = 'images/placeholder.png';
            }
        }
        
        function switchMainPreview(targetContainer) {
            thumbnailContainers.forEach(c => c.classList.remove('active'));
            targetContainer.classList.add('active');
            updateMainPreview();
        }
    </script>
</body>
</html>

