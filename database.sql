CREATE DATABASE IF NOT EXISTS jx_dealership;
USE jx_dealership;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','staff','customer') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    status ENUM('Pending','Completed','Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- 1. Create the fourth table
CREATE TABLE IF NOT EXISTS car_brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand_name VARCHAR(100) NOT NULL UNIQUE,
    country VARCHAR(100) NOT NULL DEFAULT 'Unknown'
);

-- 2. Add existing car brands to the new table
INSERT IGNORE INTO car_brands (brand_name)
SELECT DISTINCT brand
FROM cars
WHERE brand IS NOT NULL AND brand <> '';

-- 3. Add a column to link cars to their brands
ALTER TABLE cars
ADD COLUMN brand_id INT NULL;

-- 4. Connect existing cars to their brands
UPDATE cars
JOIN car_brands
    ON cars.brand = car_brands.brand_name
SET cars.brand_id = car_brands.id;

-- 5. Create the third relationship
ALTER TABLE cars
ADD CONSTRAINT fk_cars_brand
FOREIGN KEY (brand_id)
REFERENCES car_brands(id);

-- 6. Check the results
SELECT
    cars.id,
    cars.name,
    car_brands.brand_name,
    cars.price,
    cars.stock
FROM cars
LEFT JOIN car_brands
    ON cars.brand_id = car_brands.id;

-- Demo passwords:
-- admin123 / staff123 / customer123
INSERT INTO users (name,email,password,role) VALUES
('JX Admin','admin@jxhypercar.com', '$2y$12$NDfnBpgTP4QzLfcdANRUputQeCbbbmiNm1Q8tUAeqVRcsnZaYTML2', 'admin'),
('JX Staff','staff@jxhypercar.com', '$2y$12$CYCdEbDA4EfSKDeEc7FdiOw53mmPqUUn5bSzagAfvNe0Fhyfj6fxK', 'staff'),
('Demo Customer','customer@jxhypercar.com', '$2y$12$EQIDLkQ4WiVCN4hy2JfE5uq5cRjC3HGrngOAyxF0fw.WPtcPM916y', 'customer');

INSERT INTO cars (name,brand,price,stock) VALUES
('SF90 Stradale','Ferrari',1800000,3),
('Jesko','Koenigsegg',4500000,2),
('Chiron','Bugatti',6500000,1),
('Nevera','Rimac',3000000,2);
