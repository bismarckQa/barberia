-- =====================================================
-- SISTEMA DE GESTIÓN PARA BARBERÍA - LOGROÑO, ESPAÑA
-- Instalación completa de Base de Datos
-- =====================================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS barberia_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE barberia_db;

-- =====================================================
-- TABLA: CLIENTES
-- =====================================================
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    edad INT NULL,
    telefono VARCHAR(20) NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    notas TEXT NULL,
    INDEX idx_nombre (nombre),
    INDEX idx_telefono (telefono),
    INDEX idx_fecha_registro (fecha_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- TABLA: BARBEROS
-- =====================================================
CREATE TABLE IF NOT EXISTS barberos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NULL,
    fecha_ingreso DATE NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    INDEX idx_nombre (nombre),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- TABLA: SERVICIOS
-- =====================================================
CREATE TABLE IF NOT EXISTS servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    precio_sugerido DECIMAL(10,2) NOT NULL,
    INDEX idx_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- TABLA: CITAS
-- =====================================================
CREATE TABLE IF NOT EXISTS citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_cita DATE NOT NULL,
    hora_cita TIME NOT NULL,
    nota VARCHAR(100) NULL,
    estado ENUM('esperando', 'atendido', 'no_vino', 'cancelada') DEFAULT 'esperando',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_fecha_cita (fecha_cita),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- TABLA: VENTAS (CORE)
-- =====================================================
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NULL,
    barbero_id INT NOT NULL,
    servicio_id INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia', 'otro') DEFAULT 'efectivo',
    nota VARCHAR(100) NULL,
    fecha_venta DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL,
    FOREIGN KEY (barbero_id) REFERENCES barberos(id) ON DELETE RESTRICT,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE RESTRICT,
    INDEX idx_fecha_venta (fecha_venta),
    INDEX idx_cliente (cliente_id),
    INDEX idx_barbero (barbero_id),
    INDEX idx_servicio (servicio_id),
    INDEX idx_metodo_pago (metodo_pago)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- DATOS INICIALES
-- =====================================================

-- Servicios básicos (precios en euros €)
INSERT INTO servicios (nombre, descripcion, precio_sugerido) VALUES
('Corte Adulto', 'Corte de cabello para adultos', 15.00),
('Corte Niño', 'Corte de cabello para niños', 10.00),
('Barba', 'Arreglo y diseño de barba', 8.00),
('Corte + Barba', 'Combo de corte y barba', 20.00),
('Tinte', 'Aplicación de tinte', 25.00),
('Alisado', 'Tratamiento de alisado', 35.00),
('Afeitado', 'Afeitado completo', 10.00),
('Diseño', 'Diseño especial en cabello', 5.00);

-- =====================================================
-- FIN DE LA INSTALACIÓN
-- =====================================================
