<?php
/**
 * Controller de Clientes
 * CRUD completo
 */

require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {

    private $model;

    public function __construct() {
        $this->model = new Cliente();
    }

    /**
     * Validar datos de cliente
     */
    private function validarDatosCliente($data, $esNuevo = true) {
        $errores = [];

        // Validar nombre (obligatorio)
        if (empty($data['nombre'])) {
            $errores[] = 'El nombre es obligatorio';
        } else {
            $nombre = trim($data['nombre']);

            // Verificar longitud mínima
            if (strlen($nombre) < 2) {
                $errores[] = 'El nombre debe tener al menos 2 caracteres';
            }

            // Solo letras, espacios, acentos y ñ
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $nombre)) {
                $errores[] = 'El nombre solo puede contener letras';
            }
        }

        // Validar apellido (obligatorio)
        if (empty($data['apellido'])) {
            $errores[] = 'El apellido es obligatorio';
        } else {
            $apellido = trim($data['apellido']);

            // Verificar longitud mínima
            if (strlen($apellido) < 2) {
                $errores[] = 'El apellido debe tener al menos 2 caracteres';
            }

            // Solo letras, espacios, acentos y ñ
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $apellido)) {
                $errores[] = 'El apellido solo puede contener letras';
            }
        }

        // Validar teléfono (opcional)
        if (!empty($data['telefono'])) {
            $telefono = trim($data['telefono']);

            // Solo números
            if (!preg_match('/^[0-9]+$/', $telefono)) {
                $errores[] = 'El teléfono solo puede contener números';
            }

            // Longitud entre 9 y 11 dígitos
            if (strlen($telefono) < 9 || strlen($telefono) > 11) {
                $errores[] = 'El teléfono debe tener entre 9 y 11 dígitos';
            }
        }

        // Validar edad (opcional)
        if (!empty($data['edad'])) {
            $edad = $data['edad'];

            // Solo números
            if (!is_numeric($edad)) {
                $errores[] = 'La edad solo puede contener números';
            } else {
                $edad = intval($edad);

                // Rango válido
                if ($edad < 1 || $edad > 120) {
                    $errores[] = 'La edad debe estar entre 1 y 120 años';
                }
            }
        }

        return $errores;
    }

    /**
     * Listar todos los clientes
     */
    public function index() {
        return $this->model->getAll();
    }

    /**
     * Listar solo clientes activos
     */
    public function activos() {
        return $this->model->getActivos();
    }

    /**
     * Ver detalle de un cliente
     */
    public function show($id) {
        $cliente = $this->model->getById($id);
        if (!$cliente) {
            return ['error' => 'Cliente no encontrado'];
        }

        // Obtener estadísticas y historial
        $estadisticas = $this->model->getEstadisticas($id);
        $historial = $this->model->getHistorial($id);

        return [
            'cliente' => $cliente,
            'estadisticas' => $estadisticas,
            'historial' => $historial
        ];
    }

    /**
     * Crear nuevo cliente
     */
    public function store($data) {
        // Validaciones
        $errores = $this->validarDatosCliente($data, true);

        if (!empty($errores)) {
            return ['error' => implode('. ', $errores)];
        }

        // Datos por defecto
        $clienteData = [
            'nombre' => trim($data['nombre']),
            'apellido' => trim($data['apellido']),
            'edad' => !empty($data['edad']) ? intval($data['edad']) : null,
            'telefono' => !empty($data['telefono']) ? trim($data['telefono']) : null,
            'notas' => !empty($data['notas']) ? trim($data['notas']) : null,
            'estado' => $data['estado'] ?? 'activo'
        ];

        $id = $this->model->create($clienteData);

        if ($id) {
            return ['success' => true, 'id' => $id, 'message' => 'Cliente creado correctamente'];
        }

        return ['error' => 'Error al crear el cliente'];
    }

    /**
     * Actualizar cliente
     */
    public function update($id, $data) {
        // Verificar que existe
        $cliente = $this->model->getById($id);
        if (!$cliente) {
            return ['error' => 'Cliente no encontrado'];
        }

        // Validaciones
        $errores = $this->validarDatosCliente($data, false);

        if (!empty($errores)) {
            return ['error' => implode('. ', $errores)];
        }

        $clienteData = [
            'nombre' => trim($data['nombre']),
            'apellido' => trim($data['apellido']),
            'edad' => !empty($data['edad']) ? intval($data['edad']) : null,
            'telefono' => !empty($data['telefono']) ? trim($data['telefono']) : null,
            'notas' => !empty($data['notas']) ? trim($data['notas']) : null,
            'estado' => $data['estado'] ?? 'activo'
        ];

        if ($this->model->update($id, $clienteData)) {
            return ['success' => true, 'message' => 'Cliente actualizado correctamente'];
        }

        return ['error' => 'Error al actualizar el cliente'];
    }

    /**
     * Eliminar cliente
     */
    public function delete($id) {
        // Verificar que existe
        $cliente = $this->model->getById($id);
        if (!$cliente) {
            return ['error' => 'Cliente no encontrado'];
        }

        if ($this->model->delete($id)) {
            return ['success' => true, 'message' => 'Cliente eliminado correctamente'];
        }

        return ['error' => 'Error al eliminar el cliente'];
    }

    /**
     * Buscar clientes
     */
    public function search($term) {
        if (empty($term)) {
            return ['error' => 'Ingrese un término de búsqueda'];
        }

        return $this->model->search($term);
    }

    /**
     * Cambiar estado del cliente (activo/inactivo)
     */
    public function cambiarEstado($id, $estado) {
        $cliente = $this->model->getById($id);
        if (!$cliente) {
            return ['error' => 'Cliente no encontrado'];
        }

        if (!in_array($estado, ['activo', 'inactivo'])) {
            return ['error' => 'Estado inválido'];
        }

        $data = [
            'nombre' => $cliente['nombre'],
            'apellido' => $cliente['apellido'],
            'edad' => $cliente['edad'],
            'telefono' => $cliente['telefono'],
            'notas' => $cliente['notas'],
            'estado' => $estado
        ];

        if ($this->model->update($id, $data)) {
            return ['success' => true, 'message' => 'Estado actualizado correctamente'];
        }

        return ['error' => 'Error al cambiar el estado'];
    }
}
