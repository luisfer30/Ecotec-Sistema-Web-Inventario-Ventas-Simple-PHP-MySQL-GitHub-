-- Crear base de datos
CREATE DATABASE IF NOT EXISTS inventario_ventas
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

-- Usar la base
USE inventario_ventas;

-- Crear tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Datos de prueba (opcional)
INSERT INTO productos (nombre, precio, stock) VALUES
('Arroz 1kg', 1.50, 10),
('Leche 1L', 1.20, 5),
('Pan', 0.30, 20);