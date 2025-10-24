<?php
/**
 * API de Ventas
 * Maneja peticiones AJAX para CRUD de ventas
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../controllers/VentaController.php';

$controller = new VentaController();
$action = $_GET['action'] ?? '';

switch ($action) {

    case 'create':
        // Registrar nueva venta
        $data = $_POST;
        $result = $controller->store($data);
        echo json_encode($result);
        break;

    case 'update':
        // Actualizar venta
        $id = $_POST['id'] ?? 0;
        $data = $_POST;
        $result = $controller->update($id, $data);
        echo json_encode($result);
        break;

    case 'delete':
        // Eliminar venta
        $id = $_POST['id'] ?? 0;
        $result = $controller->delete($id);
        echo json_encode($result);
        break;

    case 'ventas_hoy':
        // Obtener ventas de hoy
        $ventas = $controller->ventasHoy();
        echo json_encode($ventas);
        break;

    case 'total_hoy':
        // Total de ventas de hoy
        $total = $controller->totalHoy();
        echo json_encode(['total' => $total]);
        break;

    case 'estadisticas_diarias':
        // Estadísticas diarias
        $dias = $_GET['dias'] ?? 7;
        $estadisticas = $controller->estadisticasDiarias($dias);
        echo json_encode($estadisticas);
        break;

    case 'estadisticas_semanales':
        // Estadísticas semanales
        $semanas = $_GET['semanas'] ?? 4;
        $estadisticas = $controller->estadisticasSemanales($semanas);
        echo json_encode($estadisticas);
        break;

    case 'estadisticas_mensuales':
        // Estadísticas mensuales
        $meses = $_GET['meses'] ?? 12;
        $estadisticas = $controller->estadisticasMensuales($meses);
        echo json_encode($estadisticas);
        break;

    case 'ranking_barberos':
        // Ranking de barberos
        $periodo = $_GET['periodo'] ?? 'mes';
        $ranking = $controller->rankingBarberos($periodo);
        echo json_encode($ranking);
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
