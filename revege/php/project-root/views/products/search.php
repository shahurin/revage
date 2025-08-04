<div class="search-container">
    <form method="get" class="search-form">
        <input type="hidden" name="action" value="search">
        
        <div class="form-group">
            <label for="search">商品名:</label>
            <input type="text" id="search" name="search" 
                   value="<?= htmlspecialchars($searchTerm ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                   placeholder="商品名を入力">
        </div>
        
        <div class="form-group">
            <label for="category">カテゴリ:</label>
            <select id="category" name="category">
                <option value="">すべてのカテゴリ</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>"
                        <?= ($cat === ($selectedCategory ?? '')) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="search-button">検索</button>
    </form>
</div>