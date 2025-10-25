-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS panaderia_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE panaderia_db;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    direccion TEXT NOT NULL,
    email VARCHAR(100) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de productos (panes)
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    categoria VARCHAR(50) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('Pendiente', 'En Proceso', 'Completado', 'Cancelado') DEFAULT 'Pendiente',
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de detalle de pedidos
CREATE TABLE detalle_pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo

-- Usuario de prueba (password: 123456)
INSERT INTO usuarios (nombre, email, password) VALUES
('Administrador', 'jeremy@gmail.com', '12345');

-- Clientes de ejemplo
INSERT INTO clientes (nombre, apellido, telefono, direccion, email) VALUES
('Juan', 'Pérez', '987654321', 'Av. Principal 123', 'juan@email.com'),
('María', 'García', '987654322', 'Calle Secundaria 456', 'maria@email.com'),
('Carlos', 'López', '987654323', 'Jr. Los Pinos 789', 'carlos@email.com');

-- Productos de ejemplo (panes)
INSERT INTO productos (nombre, descripcion, precio, stock, categoria) VALUES
('Pan Francés', 'Pan tradicional crujiente', 0.30, 100, 'Pan Salado'),
('Pan Integral', 'Pan saludable con granos enteros', 0.50, 80, 'Pan Integral'),
('Pan de Yema', 'Pan dulce suave y esponjoso', 0.80, 60, 'Pan Dulce'),
('Croissant', 'Hojaldre francés mantequilloso', 2.50, 40, 'Bollería'),
('Pan de Molde', 'Pan rebanado ideal para sandwiches', 5.00, 50, 'Pan Especial'),
('Empanada', 'Masa rellena horneada', 1.50, 70, 'Pan Salado'),
('Pan con Chicharrón', 'Pan crujiente con chicharrón', 3.50, 30, 'Pan Especial'),
('Bizcocho', 'Bizcocho dulce tradicional', 1.00, 90, 'Pan Dulce');

select * from usuarios;