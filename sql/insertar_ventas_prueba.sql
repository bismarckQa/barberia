-- Insertar 50 ventas de prueba (últimos 6 meses)
-- Generado automáticamente para testing de filtros

USE barberia_db;

-- Ventas de hace 6 meses (Abril 2024)
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, fecha_venta) VALUES
(1, 1, 1, 15.00, 'efectivo', '2024-04-15 10:30:00'),
(2, 6, 2, 10.00, 'tarjeta', '2024-04-15 11:45:00'),
(3, 1, 3, 8.00, 'efectivo', '2024-04-18 16:20:00'),
(NULL, 6, 4, 20.00, 'tarjeta', '2024-04-20 12:00:00'),
(4, 1, 1, 15.00, 'transferencia', '2024-04-22 09:15:00'),
(5, 6, 7, 10.00, 'efectivo', '2024-04-25 17:30:00'),
(NULL, 1, 8, 5.00, 'efectivo', '2024-04-28 14:00:00');

-- Ventas de hace 5 meses (Mayo 2024)
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, fecha_venta) VALUES
(6, 1, 1, 15.00, 'tarjeta', '2024-05-02 10:00:00'),
(7, 6, 4, 20.00, 'efectivo', '2024-05-05 11:30:00'),
(8, 1, 3, 8.00, 'tarjeta', '2024-05-08 15:45:00'),
(NULL, 6, 2, 10.00, 'efectivo', '2024-05-10 09:00:00'),
(9, 1, 9, 25.00, 'transferencia', '2024-05-12 16:00:00'),
(10, 6, 1, 15.00, 'efectivo', '2024-05-15 12:30:00'),
(1, 1, 4, 20.00, 'tarjeta', '2024-05-18 10:15:00'),
(NULL, 6, 7, 10.00, 'efectivo', '2024-05-22 14:45:00');

-- Ventas de hace 4 meses (Junio 2024)
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, fecha_venta) VALUES
(2, 1, 1, 15.00, 'efectivo', '2024-06-03 11:00:00'),
(3, 6, 3, 8.00, 'tarjeta', '2024-06-05 16:30:00'),
(4, 1, 4, 20.00, 'efectivo', '2024-06-08 10:45:00'),
(NULL, 6, 2, 10.00, 'efectivo', '2024-06-10 13:00:00'),
(5, 1, 1, 15.00, 'transferencia', '2024-06-12 09:30:00'),
(6, 6, 7, 10.00, 'tarjeta', '2024-06-15 17:00:00'),
(7, 1, 8, 5.00, 'efectivo', '2024-06-18 11:15:00'),
(8, 6, 4, 20.00, 'tarjeta', '2024-06-20 15:30:00');

-- Ventas de hace 3 meses (Julio 2024)
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, fecha_venta) VALUES
(9, 1, 1, 15.00, 'efectivo', '2024-07-02 10:30:00'),
(NULL, 6, 3, 8.00, 'efectivo', '2024-07-05 12:00:00'),
(10, 1, 4, 20.00, 'tarjeta', '2024-07-08 16:15:00'),
(1, 6, 2, 10.00, 'efectivo', '2024-07-10 09:45:00'),
(2, 1, 9, 25.00, 'transferencia', '2024-07-15 14:00:00'),
(3, 6, 1, 15.00, 'tarjeta', '2024-07-18 11:30:00'),
(NULL, 1, 7, 10.00, 'efectivo', '2024-07-22 17:45:00'),
(4, 6, 4, 20.00, 'efectivo', '2024-07-25 13:15:00');

-- Ventas de hace 2 meses (Agosto 2024)
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, fecha_venta) VALUES
(5, 1, 1, 15.00, 'tarjeta', '2024-08-01 10:00:00'),
(6, 6, 3, 8.00, 'efectivo', '2024-08-05 11:45:00'),
(7, 1, 4, 20.00, 'tarjeta', '2024-08-08 15:00:00'),
(NULL, 6, 2, 10.00, 'efectivo', '2024-08-12 09:30:00'),
(8, 1, 1, 15.00, 'efectivo', '2024-08-15 16:30:00'),
(9, 6, 7, 10.00, 'transferencia', '2024-08-18 12:15:00'),
(10, 1, 8, 5.00, 'efectivo', '2024-08-22 14:45:00'),
(NULL, 6, 4, 20.00, 'tarjeta', '2024-08-25 10:30:00');

-- Ventas del mes pasado (Septiembre 2024)
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, fecha_venta) VALUES
(1, 1, 1, 15.00, 'efectivo', '2024-09-02 11:00:00'),
(2, 6, 3, 8.00, 'tarjeta', '2024-09-05 16:00:00'),
(3, 1, 4, 20.00, 'efectivo', '2024-09-08 10:15:00'),
(NULL, 6, 2, 10.00, 'efectivo', '2024-09-12 13:30:00'),
(4, 1, 9, 25.00, 'transferencia', '2024-09-15 09:00:00'),
(5, 6, 1, 15.00, 'tarjeta', '2024-09-18 17:15:00'),
(6, 1, 7, 10.00, 'efectivo', '2024-09-22 11:45:00'),
(NULL, 6, 4, 20.00, 'tarjeta', '2024-09-25 15:30:00');

-- Ventas del mes actual (Octubre 2024)
INSERT INTO ventas (cliente_id, barbero_id, servicio_id, precio, metodo_pago, fecha_venta) VALUES
(7, 1, 1, 15.00, 'efectivo', '2024-10-01 10:30:00'),
(8, 6, 3, 8.00, 'tarjeta', '2024-10-03 12:00:00'),
(9, 1, 4, 20.00, 'efectivo', '2024-10-05 16:15:00'),
(NULL, 6, 2, 10.00, 'efectivo', '2024-10-08 09:45:00');

SELECT '✅ Se insertaron 51 registros de ventas correctamente' as mensaje;
SELECT CONCAT('📊 Total de ventas en la base de datos: ', COUNT(*)) as total FROM ventas;
