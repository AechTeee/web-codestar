-- Khoi tao CSDL
-- Chay lenh nay truoc khi dung bt-cn.php

CREATE DATABASE IF NOT EXISTS web CHARACTER SET utf8 COLLATE utf8_general_ci;
USE web;

-- CREATE bang san pham
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) DEFAULT 0,
    quantity INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- INSERT du lieu demo
INSERT INTO products (name, description, price, quantity) VALUES
('Bánh mì', 'Bánh mì Hà Nội', 15000, 100),
('Sữa', 'Sữa tươm 2%, 1L', 24000, 50),
('Trứng', 'Trứng gà cúng đất', 35000, 30);
