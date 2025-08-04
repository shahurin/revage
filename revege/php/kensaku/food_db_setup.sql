-- データベース作成 (存在しない場合)
CREATE DATABASE IF NOT EXISTS food_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- データベースを使用
USE food_db;

-- 商品テーブル
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- レシピテーブル
CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    instructions TEXT NOT NULL,
    cooking_time INT NOT NULL COMMENT '調理時間(分)',
    difficulty TINYINT COMMENT '難易度(1-5)',
    servings TINYINT COMMENT '何人前',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- レシピ材料テーブル
CREATE TABLE IF NOT EXISTS recipe_ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity VARCHAR(100) NOT NULL COMMENT '分量(例: 大さじ2, 1個)',
    unit VARCHAR(50) COMMENT '単位',
    notes VARCHAR(255) COMMENT '備考',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_recipe (recipe_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ユーザー在庫テーブル
CREATE TABLE IF NOT EXISTS user_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    expiry_date DATE COMMENT '消費期限',
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_product (product_id),
    INDEX idx_expiry (expiry_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- サンプルデータ挿入 (オプション)
-- 商品データ
INSERT INTO products (name, category, price, stock) VALUES
('にんじん', '野菜', 98, 50),
('たまねぎ', '野菜', 78, 100),
('鶏もも肉', '肉', 298, 30),
('鮭', '魚', 398, 20),
('醤油', '調味料', 198, 40),
('米', '主食', 1980, 25),
('卵', '乳製品', 248, 60);

-- レシピデータ
INSERT INTO recipes (name, instructions, cooking_time, difficulty, servings) VALUES
('親子丼', '1. 鶏肉を一口大に切る\n2. 玉ねぎを薄切りにする\n3. 鍋に出汁、醤油、みりんを入れ沸騰させる\n4. 鶏肉と玉ねぎを加え煮る\n5. 溶き卵を加え半熟状態で火を止める\n6. ご飯の上にのせる', 20, 2, 2),
('鮭のムニエル', '1. 鮭に塩胡椒をふる\n2. 小麦粉をまぶす\n3. フライパンにバターを熱し鮭を焼く\n4. レモンを添える', 15, 1, 1);

-- レシピ材料データ
INSERT INTO recipe_ingredients (recipe_id, product_id, quantity, unit, notes) VALUES
(1, 3, '200', 'g', '鶏もも肉'),
(1, 2, '1/2', '個', '中玉'),
(1, 5, '2', '大さじ', NULL),
(1, 6, '適量', NULL, 'ご飯'),
(1, 7, '2', '個', NULL),
(2, 4, '1', '切れ', NULL),
(2, 5, '少々', NULL, NULL);