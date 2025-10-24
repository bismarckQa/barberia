-- Script de datos de prueba para Sistema Barbería
-- 4 Barberos y 15 Clientes

USE barberia_db;

-- =====================================================
-- INSERTAR 4 BARBEROS
-- =====================================================

INSERT INTO barberos (nombre, apellido, telefono, fecha_ingreso, estado) VALUES
('Carlos', 'Martínez', '941234567', '2022-01-15', 'activo'),
('Miguel', 'González', '941234568', '2022-06-20', 'activo'),
('Javier', 'Rodríguez', '941234569', '2023-02-10', 'activo'),
('Antonio', 'López', '941234570', '2023-08-01', 'activo');

-- =====================================================
-- INSERTAR 15 CLIENTES
-- =====================================================

INSERT INTO clientes (nombre, apellido, telefono, edad, notas, estado) VALUES
('Juan', 'Pérez García', '626123456', 28, 'Prefiere corte clásico', 'activo'),
('Pedro', 'Sánchez Ruiz', '626123457', 35, 'Cliente habitual, cada 3 semanas', 'activo'),
('Luis', 'Fernández López', '626123458', 42, 'Le gusta el degradado', 'activo'),
('Andrés', 'Moreno Díaz', '626123459', 31, 'Alérgico a ciertos productos', 'activo'),
('Francisco', 'Ramírez Torres', '626123460', 25, 'Estilo moderno', 'activo'),
('David', 'García Navarro', '626123461', 38, 'Barbas y corte completo', 'activo'),
('José', 'Jiménez Ruiz', '626123462', 45, 'Canas, prefiere tinte natural', 'activo'),
('Manuel', 'Álvarez Serrano', '626123463', 29, 'Corte rapido, sin diseños', 'activo'),
('Ricardo', 'Romero Castro', '626123464', 33, 'Le gusta probar estilos nuevos', 'activo'),
('Alberto', 'Ortiz Herrera', '626123465', 27, 'Viene los sábados', 'activo'),
('Sergio', 'Delgado Ramos', '626123466', 40, 'Solo arreglo de barba', 'activo'),
('Fernando', 'Núñez Medina', '626123467', 36, 'Corte ejecutivo', 'activo'),
('Pablo', 'Cabrera Vega', '626123468', 30, 'Cliente nuevo, estilo juvenil', 'activo'),
('Raúl', 'Iglesias Molina', '626123469', 44, 'Corte tradicional', 'activo'),
('Jorge', 'Castro Méndez', '626123470', 26, 'Diseños en el cabello', 'activo');

-- =====================================================
-- VERIFICAR DATOS INSERTADOS
-- =====================================================

SELECT '=== BARBEROS INSERTADOS ===' as '';
SELECT id, nombre, apellido, telefono, fecha_ingreso, estado FROM barberos;

SELECT '=== CLIENTES INSERTADOS ===' as '';
SELECT id, nombre, apellido, telefono, edad, estado FROM clientes;

SELECT CONCAT('Total Barberos: ', COUNT(*)) as 'Resumen' FROM barberos;
SELECT CONCAT('Total Clientes: ', COUNT(*)) as 'Resumen' FROM clientes;
