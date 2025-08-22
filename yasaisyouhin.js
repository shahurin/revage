// DOMが読み込まれたら処理を開始
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== サムネイル切り替え機能 (既存) =====
    const mainImage = document.querySelector('.main-image');
    const thumbnails = document.querySelectorAll('.thumbnail');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // 1. 現在アクティブなサムネイルから 'active' クラスを削除
            const currentActive = document.querySelector('.thumbnail.active');
            if (currentActive) {
                currentActive.classList.remove('active');
            }
            
            // 2. クリックされたサムネイルに 'active' クラスを追加
            this.classList.add('active');
            
            // 3. メイン画像のsrcを、クリックされたサムネイルのsrcに設定
            mainImage.src = this.src;
        });
    });

    // ===== サイズ選択モーダル機能 (ここから追加) =====
    const appContainer = document.querySelector('.app-container');
    const openModalBtn = document.querySelector('.size-selector');
    const closeModalBtn = document.getElementById('close-modal');
    const modalOverlay = document.getElementById('size-modal-overlay');
    const sizeOptions = document.querySelectorAll('.size-option');
    const selectedSizeDisplay = document.querySelector('.selector-value span');

    // モーダルを開く関数
    function openModal() {
        appContainer.classList.add('modal-open');
    }

    // モーダルを閉じる関数
    function closeModal() {
        appContainer.classList.remove('modal-open');
    }

    // 「サイズを選択」をクリックしたらモーダルを開く
    if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
    }

    // 閉じるボタンかオーバーレイをクリックしたらモーダルを閉じる
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    if (modalOverlay) {
        modalOverlay.addEventListener('click', closeModal);
    }

    // 各サイズオプションをクリックしたときの処理
    sizeOptions.forEach(option => {
        option.addEventListener('click', function() {
            // 1. 現在アクティブなオプションから 'active' クラスを削除
            const currentActiveOption = document.querySelector('.size-option.active');
            if (currentActiveOption) {
                currentActiveOption.classList.remove('active');
            }
            
            // 2. クリックされたオプションに 'active' クラスを追加
            this.classList.add('active');

            // 3. 表示されているサイズを更新
            if (selectedSizeDisplay) {
                selectedSizeDisplay.textContent = this.dataset.size;
            }

            // 4. モーダルを閉じる
            closeModal();
        });
    });
});