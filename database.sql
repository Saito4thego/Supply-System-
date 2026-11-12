CREATE DATABASE IF NOT EXISTS supplier_db;
USE supplier_db;

CREATE TABLE suppliers (
  supplier_id INT AUTO_INCREMENT PRIMARY KEY,
  company_name VARCHAR(100) NOT NULL,
  contact_person VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address TEXT,
  status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_id INT NOT NULL,
  product_name VARCHAR(100) NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  stock_qty INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO suppliers (company_name, contact_person, email, phone, address, status) VALUES
('Visayas Fresh Foods', 'Maria Santos', 'maria@visayasfresh.ph', '09171234567', 'Iloilo City', 'Active'),
('Panay Hardware Supply', 'Jose Reyes', 'jose@panayhw.ph', '09189876543', 'Roxas City', 'Active'),
('Island Packaging Co.', 'Ana Cruz', 'ana@islandpack.ph', '09201112233', 'Bacolod City', 'Inactive');

INSERT INTO products (supplier_id, product_name, unit_price, stock_qty) VALUES
(1, 'Rice 25kg', 1350.00, 40),
(1, 'Cooking Oil 1L', 95.50, 6),
(2, 'Cement 40kg', 285.00, 120),
(2, 'GI Sheet', 410.00, 4);
