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
