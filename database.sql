CREATE DATABASE IF NOT EXISTS qr_food_ordering
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE qr_food_ordering;

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS menu_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(255) DEFAULT '',
  category VARCHAR(60) NOT NULL DEFAULT 'Other',
  price DECIMAL(10,2) NOT NULL,
  available TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(100) NOT NULL,
  table_number VARCHAR(20) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  status ENUM('Pending','Preparing','Ready','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  menu_item_id INT NULL,
  item_name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE SET NULL
);

INSERT INTO menu_items (name, description, category, price) VALUES
('Veg Sandwich', 'Fresh vegetable sandwich', 'Snacks', 60.00),
('Masala Dosa', 'Crispy dosa with potato masala', 'South Indian', 90.00),
('Veg Burger', 'Burger with vegetable patty', 'Snacks', 80.00),
('French Fries', 'Crispy salted fries', 'Sides', 70.00),
('Cold Coffee', 'Chilled coffee drink', 'Beverages', 65.00),
('Masala Chai', 'Indian tea with spices', 'Beverages', 20.00);
