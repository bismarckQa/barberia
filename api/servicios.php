<?php
/**
 * API de Servicios
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../controllers/ServicioController.php';

$controller = new ServicioController();
$action = $_GET['action'] ?? '';

switch ($action) {

    case 'create':
        $data = $_POST;
        $result = $controller->store($data);
        echo json_encode($result);
        break;

    case 'update':
        $id = $_POST['id'] ?? 0;
        $data = $_POST;
        $result = $controller->update($id, $data);
        echo json_encode($result);
        break;

    case 'delete':
        $id = $_POST['id'] ?? 0;
        $result = $controller->delete($id);
        echo json_encode($result);
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
