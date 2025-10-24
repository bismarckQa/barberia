<?php
/**
 * API de Clientes
 * Maneja peticiones AJAX para CRUD de clientes
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../controllers/ClienteController.php';

$controller = new ClienteController();
$action = $_GET['action'] ?? '';

switch ($action) {

    case 'search':
        // Búsqueda de clientes
        $term = $_GET['q'] ?? '';
        $clientes = $controller->search($term);
        echo json_encode($clientes);
        break;

    case 'create':
        // Crear nuevo cliente
        $data = $_POST;
        $result = $controller->store($data);
        echo json_encode($result);
        break;

    case 'update':
        // Actualizar cliente
        $id = $_POST['id'] ?? 0;
        $data = $_POST;
        $result = $controller->update($id, $data);
        echo json_encode($result);
        break;

    case 'delete':
        // Eliminar cliente
        $id = $_POST['id'] ?? 0;
        $result = $controller->delete($id);
        echo json_encode($result);
        break;

    case 'cambiar_estado':
        // Cambiar estado
        $id = $_POST['id'] ?? 0;
        $estado = $_POST['estado'] ?? 'activo';
        $result = $controller->cambiarEstado($id, $estado);
        echo json_encode($result);
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
