<?php
/**
 * API de Citas
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../controllers/CitaController.php';

$controller = new CitaController();
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

    case 'cambiar_estado':
        $id = $_POST['id'] ?? 0;
        $estado = $_POST['estado'] ?? 'esperando';
        $result = $controller->cambiarEstado($id, $estado);
        echo json_encode($result);
        break;

    case 'citas_hoy':
        $citas = $controller->citasHoy();
        echo json_encode($citas);
        break;

    case 'proximas':
        $limit = $_GET['limit'] ?? 10;
        $citas = $controller->proximas($limit);
        echo json_encode($citas);
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
