CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255),
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    drink VARCHAR(100) NOT NULL,
    topping VARCHAR(50),
    sugar VARCHAR(20),
    ice VARCHAR(20),
    address TEXT,
    total DECIMAL(10,2),
    status VARCHAR(50) DEFAULT 'Chờ xác nhận',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Mẫu menu 
INSERT INTO menu_items (name, description, price, category) VALUES
('Trà sữa classic', 'Trà đen, sữa tươi, tapioca', 35000, 'Trà sữa'),
('Dâu sữa', 'Trà dâu tươi, sữa tươi, kem cheese', 45000, 'Trà sữa'),
('Trà nho đen', 'Nho đen, jasmine tea, jelly', 50000, 'Trà sữa'),
('Trà xanh matcha', 'Matcha cao cấp, sữa tươi, foam', 42000, 'Trà sữa'),
('Trà chanh', 'Chanh tươi, jasmine tea, đường', 38000, 'Trà trái cây'),
('Sinh tố xoài', 'Xôi tươi, sữa đặc, đá xay', 55000, 'Sinh tố'),
('Cà phê sữa đá', 'Cà phê phin truyền thống', 30000, 'Cà phê'),
('Sữa tươi nguyên kem', 'Sữa tươi nguyên kem, đường', 40000, 'Sữa');