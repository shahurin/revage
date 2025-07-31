// DOMが読み込まれたら処理を開始
document.addEventListener('DOMContentLoaded', function() {
    // 必要な要素を取得
    const mainImage = document.querySelector('.main-image');
    const thumbnails = document.querySelectorAll('.thumbnail');

    // 各サムネイルにクリックイベントを設定
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
});