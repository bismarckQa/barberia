-- Script para agregar CITAS DE PRUEBA
-- Esto mostrará las próximas citas en el dashboard

USE barberia_db;

-- =====================================================
-- INSERTAR CITAS DE PRUEBA (próximas fechas)
-- =====================================================

-- Citas de HOY
INSERT INTO citas (nombre_cliente, telefono, fecha_cita, hora_cita, nota, estado) VALUES
('Carlos Ruiz', '626111222', CURDATE(), '10:00:00', 'Primera vez', 'esperando'),
('David Sánchez', '626222333', CURDATE(), '11:30:00', 'Corte + barba', 'esperando'),
('Miguel Torres', '626333444', CURDATE(), '15:00:00', NULL, 'esperando');

-- Citas de MAÑANA
INSERT INTO citas (nombre_cliente, telefono, fecha_cita, hora_cita, nota, estado) VALUES
('Alberto Gómez', '626444555', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '09:00:00', 'Diseño especial', 'esperando'),
('Fernando López', '626555666', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '12:00:00', NULL, 'esperando'),
('Sergio Martín', '626666777', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '16:30:00', 'Solo barba', 'esperando');

-- Citas de PASADO MAÑANA
INSERT INTO citas (nombre_cliente, telefono, fecha_cita, hora_cita, nota, estado) VALUES
('Pablo Hernández', '626777888', DATE_ADD(CURDATE(), INTERVAL 2 DAY), '10:30:00', 'Cliente habitual', 'esperando'),
('Ricardo Jiménez', '626888999', DATE_ADD(CURDATE(), INTERVAL 2 DAY), '14:00:00', NULL, 'esperando');

-- Citas de la PRÓXIMA SEMANA
INSERT INTO citas (nombre_cliente, telefono, fecha_cita, hora_cita, nota, estado) VALUES
('Jorge Navarro', '626999000', DATE_ADD(CURDATE(), INTERVAL 7 DAY), '11:00:00', 'Evento importante', 'esperando'),
('Andrés Castro', '626000111', DATE_ADD(CURDATE(), INTERVAL 7 DAY), '17:00:00', NULL, 'esperando');

-- Algunas citas PASADAS (para historial)
INSERT INTO citas (nombre_cliente, telefono, fecha_cita, hora_cita, nota, estado) VALUES
('Luis Pérez', '626111000', DATE_SUB(CURDATE(), INTERVAL 1 DAY), '10:00:00', 'Vino puntual', 'atendido'),
('Manuel Díaz', '626222000', DATE_SUB(CURDATE(), INTERVAL 2 DAY), '15:00:00', NULL, 'atendido'),
('José Ramírez', '626333000', DATE_SUB(CURDATE(), INTERVAL 3 DAY), '12:00:00', 'No se presentó', 'no_vino');

-- =====================================================
-- VERIFICAR CITAS INSERTADAS
-- =====================================================

SELECT '=== CITAS PRÓXIMAS (Esperando) ===' as '';
SELECT id, nombre_cliente, telefono, fecha_cita, hora_cita, estado
FROM citas
WHERE estado = 'esperando' AND fecha_cita >= CURDATE()
ORDER BY fecha_cita ASC, hora_cita ASC;

SELECT '=== TOTAL DE CITAS ===' as '';
SELECT
    CONCAT('Total: ', COUNT(*)) as 'Total Citas',
    CONCAT('Esperando: ', SUM(CASE WHEN estado = 'esperando' THEN 1 ELSE 0 END)) as 'Esperando',
    CONCAT('Atendidas: ', SUM(CASE WHEN estado = 'atendido' THEN 1 ELSE 0 END)) as 'Atendidas',
    CONCAT('No Vinieron: ', SUM(CASE WHEN estado = 'no_vino' THEN 1 ELSE 0 END)) as 'No Vinieron'
FROM citas;
