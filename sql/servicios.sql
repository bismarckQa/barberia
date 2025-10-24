-- Tabla de Servicios
CREATE TABLE IF NOT EXISTS servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    precio_sugerido DECIMAL(10,2) NOT NULL,
    INDEX idx_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar servicios básicos (precios en euros)
INSERT INTO servicios (nombre, descripcion, precio_sugerido) VALUES
('Corte Adulto', 'Corte de cabello para adultos', 15.00),
('Corte Niño', 'Corte de cabello para niños', 10.00),
('Barba', 'Arreglo y diseño de barba', 8.00),
('Corte + Barba', 'Combo de corte y barba', 20.00),
('Tinte', 'Aplicación de tinte', 25.00),
('Alisado', 'Tratamiento de alisado', 35.00),
('Afeitado', 'Afeitado completo', 10.00),
('Diseño', 'Diseño especial en cabello', 5.00);
