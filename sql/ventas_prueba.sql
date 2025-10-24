-- Script para agregar VENTAS DE PRUEBA
-- 30 ventas distribuidas en los últimos 6 meses
-- Esto poblará las estadísticas y reportes con datos históricos

USE barberia_db;

-- =====================================================
-- INSERTAR 30 VENTAS DE PRUEBA (últimos 6 meses)
-- =====================================================

-- MES 1 (hace 6 meses) - 4 ventas
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, nota, fecha_venta) VALUES
(1, 1, 11, 12.00, 'efectivo', NULL, DATE_SUB(NOW(), INTERVAL 180 DAY) + INTERVAL 10 HOUR),
(2, 2, 3, 8.00, 'tarjeta', 'Cliente satisfecho', DATE_SUB(NOW(), INTERVAL 177 DAY) + INTERVAL 11 HOUR + INTERVAL 30 MINUTE),
(NULL, 3, 2, 8.00, 'efectivo', 'Sin cita', DATE_SUB(NOW(), INTERVAL 174 DAY) + INTERVAL 16 HOUR),
(3, 1, 4, 20.00, 'tarjeta', NULL, DATE_SUB(NOW(), INTERVAL 171 DAY) + INTERVAL 14 HOUR + INTERVAL 15 MINUTE);

-- MES 2 (hace 5 meses) - 5 ventas
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, nota, fecha_venta) VALUES
(4, 2, 11, 12.00, 'efectivo', NULL, DATE_SUB(NOW(), INTERVAL 150 DAY) + INTERVAL 9 HOUR + INTERVAL 30 MINUTE),
(5, 3, 4, 20.00, 'tarjeta', 'Diseño especial', DATE_SUB(NOW(), INTERVAL 147 DAY) + INTERVAL 12 HOUR),
(NULL, 1, 2, 8.00, 'efectivo', NULL, DATE_SUB(NOW(), INTERVAL 144 DAY) + INTERVAL 17 HOUR + INTERVAL 30 MINUTE),
(6, 4, 1, 15.00, 'transferencia', 'Paquete completo', DATE_SUB(NOW(), INTERVAL 141 DAY) + INTERVAL 10 HOUR + INTERVAL 45 MINUTE),
(7, 2, 3, 8.00, 'tarjeta', NULL, DATE_SUB(NOW(), INTERVAL 138 DAY) + INTERVAL 15 HOUR);

-- MES 3 (hace 4 meses) - 5 ventas
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, nota, fecha_venta) VALUES
(8, 1, 11, 12.00, 'efectivo', 'Muy puntual', DATE_SUB(NOW(), INTERVAL 120 DAY) + INTERVAL 11 HOUR),
(NULL, 3, 2, 8.00, 'efectivo', 'Walk-in', DATE_SUB(NOW(), INTERVAL 117 DAY) + INTERVAL 13 HOUR + INTERVAL 30 MINUTE),
(9, 2, 9, 35.00, 'tarjeta', NULL, DATE_SUB(NOW(), INTERVAL 114 DAY) + INTERVAL 16 HOUR + INTERVAL 15 MINUTE),
(10, 4, 7, 10.00, 'transferencia', 'Afeitado clásico', DATE_SUB(NOW(), INTERVAL 111 DAY) + INTERVAL 10 HOUR),
(11, 1, 3, 8.00, 'tarjeta', NULL, DATE_SUB(NOW(), INTERVAL 108 DAY) + INTERVAL 14 HOUR + INTERVAL 30 MINUTE);

-- MES 4 (hace 3 meses) - 5 ventas
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, nota, fecha_venta) VALUES
(12, 2, 11, 12.00, 'efectivo', NULL, DATE_SUB(NOW(), INTERVAL 90 DAY) + INTERVAL 9 HOUR),
(13, 3, 4, 22.00, 'tarjeta', 'Degradado fade', DATE_SUB(NOW(), INTERVAL 87 DAY) + INTERVAL 12 HOUR + INTERVAL 15 MINUTE),
(NULL, 1, 2, 8.00, 'efectivo', NULL, DATE_SUB(NOW(), INTERVAL 84 DAY) + INTERVAL 17 HOUR),
(14, 4, 8, 5.00, 'tarjeta', 'Diseño en lateral', DATE_SUB(NOW(), INTERVAL 81 DAY) + INTERVAL 11 HOUR + INTERVAL 30 MINUTE),
(15, 2, 4, 20.00, 'transferencia', NULL, DATE_SUB(NOW(), INTERVAL 78 DAY) + INTERVAL 15 HOUR + INTERVAL 45 MINUTE);

-- MES 5 (hace 2 meses) - 6 ventas
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, nota, fecha_venta) VALUES
(1, 1, 11, 12.00, 'efectivo', 'Cliente recurrente', DATE_SUB(NOW(), INTERVAL 60 DAY) + INTERVAL 10 HOUR),
(2, 3, 3, 8.00, 'tarjeta', NULL, DATE_SUB(NOW(), INTERVAL 57 DAY) + INTERVAL 13 HOUR + INTERVAL 30 MINUTE),
(NULL, 2, 2, 8.00, 'efectivo', 'Sin reserva', DATE_SUB(NOW(), INTERVAL 54 DAY) + INTERVAL 16 HOUR),
(3, 4, 7, 10.00, 'transferencia', 'Afeitado completo', DATE_SUB(NOW(), INTERVAL 51 DAY) + INTERVAL 11 HOUR + INTERVAL 15 MINUTE),
(4, 1, 4, 20.00, 'tarjeta', NULL, DATE_SUB(NOW(), INTERVAL 48 DAY) + INTERVAL 14 HOUR + INTERVAL 30 MINUTE),
(5, 2, 1, 15.00, 'tarjeta', 'Corte adulto', DATE_SUB(NOW(), INTERVAL 45 DAY) + INTERVAL 9 HOUR + INTERVAL 45 MINUTE);

-- MES 6 (hace 1 mes) - 5 ventas
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, nota, fecha_venta) VALUES
(6, 3, 11, 12.00, 'efectivo', NULL, DATE_SUB(NOW(), INTERVAL 30 DAY) + INTERVAL 10 HOUR + INTERVAL 30 MINUTE),
(7, 1, 9, 35.00, 'tarjeta', 'Tinte normal', DATE_SUB(NOW(), INTERVAL 27 DAY) + INTERVAL 12 HOUR),
(NULL, 4, 2, 8.00, 'efectivo', NULL, DATE_SUB(NOW(), INTERVAL 24 DAY) + INTERVAL 15 HOUR + INTERVAL 30 MINUTE),
(8, 2, 3, 8.00, 'tarjeta', NULL, DATE_SUB(NOW(), INTERVAL 21 DAY) + INTERVAL 11 HOUR + INTERVAL 15 MINUTE),
(9, 3, 8, 5.00, 'transferencia', 'Diseño especial', DATE_SUB(NOW(), INTERVAL 18 DAY) + INTERVAL 16 HOUR);

-- =====================================================
-- VERIFICAR VENTAS INSERTADAS
-- =====================================================

SELECT '=== RESUMEN DE VENTAS POR MES ===' as '';
SELECT
    DATE_FORMAT(fecha_venta, '%Y-%m') as Mes,
    COUNT(*) as 'Total Ventas',
    CONCAT(SUM(precio), ' €') as 'Ingresos',
    CONCAT(ROUND(AVG(precio), 2), ' €') as 'Precio Medio'
FROM ventas
GROUP BY DATE_FORMAT(fecha_venta, '%Y-%m')
ORDER BY Mes DESC;

SELECT '=== TOTAL GENERAL ===' as '';
SELECT
    CONCAT('Total ventas: ', COUNT(*)) as 'Total',
    CONCAT('Ingresos totales: ', SUM(precio), ' €') as 'Ingresos',
    CONCAT('Precio medio: ', ROUND(AVG(precio), 2), ' €') as 'Precio Medio'
FROM ventas;

SELECT '=== VENTAS POR BARBERO ===' as '';
SELECT
    CONCAT(b.nombre, ' ', b.apellido) as Barbero,
    COUNT(v.id) as 'Total Ventas',
    CONCAT(SUM(v.precio), ' €') as 'Ingresos'
FROM ventas v
JOIN barberos b ON v.barbero_id = b.id
GROUP BY v.barbero_id
ORDER BY COUNT(v.id) DESC;

SELECT '=== SERVICIOS MÁS VENDIDOS ===' as '';
SELECT
    s.nombre as Servicio,
    COUNT(v.id) as 'Veces Vendido',
    CONCAT(SUM(v.precio), ' €') as 'Ingresos'
FROM ventas v
JOIN servicios s ON v.servicio_id = s.id
GROUP BY v.servicio_id
ORDER BY COUNT(v.id) DESC;
