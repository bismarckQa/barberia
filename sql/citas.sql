-- Tabla de Citas/Agenda
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
