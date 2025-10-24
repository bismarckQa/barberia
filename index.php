<?php
/**
 * Router Principal - Sistema Barbería
 * Maneja todas las rutas de la aplicación
 */

// Obtener la ruta solicitada
$request = $_GET['page'] ?? 'dashboard';

// Mapeo de rutas
$routes = [
    'dashboard' => 'views/dashboard.php',

    // Clientes
    'clientes' => 'views/clientes/index.php',
    'clientes/nuevo' => 'views/clientes/nuevo.php',
    'clientes/editar' => 'views/clientes/editar.php',
    'clientes/ver' => 'views/clientes/ver.php',

    // Barberos
    'barberos' => 'views/barberos/index.php',
    'barberos/nuevo' => 'views/barberos/nuevo.php',
    'barberos/editar' => 'views/barberos/editar.php',

    // Servicios
    'servicios' => 'views/servicios/index.php',
    'servicios/nuevo' => 'views/servicios/nuevo.php',
    'servicios/editar' => 'views/servicios/editar.php',

    // Citas
    'citas' => 'views/citas/index.php',
    'citas/nueva' => 'views/citas/nueva.php',
    'citas/editar' => 'views/citas/editar.php',

    // Ventas
    'ventas' => 'views/ventas/index.php',
    'ventas/nueva' => 'views/ventas/nueva.php',
    'ventas/editar' => 'views/ventas/editar.php',

    // Reportes
    'reportes' => 'views/reportes/index.php',
];

// Verificar si la ruta existe
if (array_key_exists($request, $routes) && file_exists($routes[$request])) {
    include $routes[$request];
} else {
    include 'views/404.php';
}
