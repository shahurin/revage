DROP DATABASE IF EXISTS revege;
CREATE DATABASE revege DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP USER IF EXISTS 'revege_staff'@'localhost';
CREATE USER 'revege_staff'@'localhost' IDENTIFIED BY 'password';
GRANT ALL ON revege.* TO 'revege_staff'@'localhost';

USE revege;

CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    address VARCHAR(200) NOT NULL,
    user_id VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    detail VARCHAR(500) NOT NULL,  -- 長さを指定
    price INT NOT NULL,            -- 金額なのでINT推奨
    seller VARCHAR(200) NOT NULL,   -- 長さを指定
    image  VARCHAR(200) NOT NULL
);

CREATE TABLE recipe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    poster VARCHAR(200) NOT NULL   -- 小文字に統一推奨
);

-- 商品画像テーブル
CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,    -- 送信者 (customer.id)
    receiver_id INT NOT NULL,  -- 受信者 (customer.id)
    message TEXT NOT NULL,     -- 本文
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES customer(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES customer(id) ON DELETE CASCADE
);


INSERT INTO customer
VALUES (NULL, '清風太郎', '大阪', 'SEIFU', 'SEIFU');





