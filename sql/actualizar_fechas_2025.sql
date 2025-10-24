-- Actualizar todas las ventas de 2024 a 2025
-- Para que coincidan con el año actual del sistema

USE barberia_db;

-- Actualizar ventas de abril 2024 → abril 2025
UPDATE ventas
SET fecha_venta = DATE_ADD(fecha_venta, INTERVAL 1 YEAR)
WHERE YEAR(fecha_venta) = 2024 AND MONTH(fecha_venta) = 4;

-- Actualizar ventas de mayo 2024 → mayo 2025
UPDATE ventas
SET fecha_venta = DATE_ADD(fecha_venta, INTERVAL 1 YEAR)
WHERE YEAR(fecha_venta) = 2024 AND MONTH(fecha_venta) = 5;

-- Actualizar ventas de junio 2024 → junio 2025
UPDATE ventas
SET fecha_venta = DATE_ADD(fecha_venta, INTERVAL 1 YEAR)
WHERE YEAR(fecha_venta) = 2024 AND MONTH(fecha_venta) = 6;

-- Actualizar ventas de julio 2024 → julio 2025
UPDATE ventas
SET fecha_venta = DATE_ADD(fecha_venta, INTERVAL 1 YEAR)
WHERE YEAR(fecha_venta) = 2024 AND MONTH(fecha_venta) = 7;

-- Actualizar ventas de agosto 2024 → agosto 2025
UPDATE ventas
SET fecha_venta = DATE_ADD(fecha_venta, INTERVAL 1 YEAR)
WHERE YEAR(fecha_venta) = 2024 AND MONTH(fecha_venta) = 8;

-- Actualizar ventas de septiembre 2024 → septiembre 2025
UPDATE ventas
SET fecha_venta = DATE_ADD(fecha_venta, INTERVAL 1 YEAR)
WHERE YEAR(fecha_venta) = 2024 AND MONTH(fecha_venta) = 9;

-- Actualizar ventas de octubre 2024 → octubre 2025
UPDATE ventas
SET fecha_venta = DATE_ADD(fecha_venta, INTERVAL 1 YEAR)
WHERE YEAR(fecha_venta) = 2024 AND MONTH(fecha_venta) = 10;

SELECT '✅ Fechas actualizadas de 2024 a 2025' as mensaje;
SELECT MIN(fecha_venta) as primera, MAX(fecha_venta) as ultima FROM ventas;
SELECT DATE_FORMAT(fecha_venta, '%Y-%m') as mes, COUNT(*) as ventas FROM ventas GROUP BY DATE_FORMAT(fecha_venta, '%Y-%m') ORDER BY mes DESC;
