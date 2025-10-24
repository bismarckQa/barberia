<?php
/**
 * Controller de Barberos
 * CRUD con validación de eliminación (no se puede eliminar si tiene ventas)
 */

require_once __DIR__ . '/../models/Barbero.php';
require_once __DIR__ . '/../models/Venta.php';

class BarberoController {

    private $model;
    private $ventaModel;

    public function __construct() {
        $this->model = new Barbero();
        $this->ventaModel = new Venta();
    }

    /**
     * Listar todos los barberos
     */
    public function index() {
        return $this->model->getAll();
    }

    /**
     * Listar solo barberos activos
     */
    public function activos() {
        return $this->model->getActivos();
    }

    /**
     * Ver detalle de un barbero con estadísticas
     */
    public function show($id) {
        $barbero = $this->model->getById($id);
        if (!$barbero) {
            return ['error' => 'Barbero no encontrado'];
        }

        // Obtener estadísticas
        $estadisticas = [
            'servicios_hoy' => $this->model->getServiciosHoy($id),
            'servicios_semana' => $this->model->getServiciosSemana($id),
            'servicios_mes' => $this->model->getServiciosMes($id),
            'total_servicios' => $this->model->getTotalServicios($id),
            'servicios_mas_realizados' => $this->model->getServiciosMasRealizados($id)
        ];

        return [
            'barbero' => $barbero,
            'estadisticas' => $estadisticas
        ];
    }

    /**
     * Crear nuevo barbero
     */
    public function store($data) {
        // Validaciones
        if (empty($data['nombre']) || empty($data['apellido'])) {
            return ['error' => 'Nombre y apellido son obligatorios'];
        }

        if (empty($data['fecha_ingreso'])) {
            return ['error' => 'Fecha de ingreso es obligatoria'];
        }

        $barberoData = [
            'nombre' => trim($data['nombre']),
            'apellido' => trim($data['apellido']),
            'telefono' => $data['telefono'] ?? null,
            'fecha_ingreso' => $data['fecha_ingreso'],
            'estado' => $data['estado'] ?? 'activo'
        ];

        $id = $this->model->create($barberoData);

        if ($id) {
            return ['success' => true, 'id' => $id, 'message' => 'Barbero registrado correctamente'];
        }

        return ['error' => 'Error al registrar el barbero'];
    }

    /**
     * Actualizar barbero
     */
    public function update($id, $data) {
        $barbero = $this->model->getById($id);
        if (!$barbero) {
            return ['error' => 'Barbero no encontrado'];
        }

        if (empty($data['nombre']) || empty($data['apellido'])) {
            return ['error' => 'Nombre y apellido son obligatorios'];
        }

        if (empty($data['fecha_ingreso'])) {
            return ['error' => 'Fecha de ingreso es obligatoria'];
        }

        $barberoData = [
            'nombre' => trim($data['nombre']),
            'apellido' => trim($data['apellido']),
            'telefono' => $data['telefono'] ?? null,
            'fecha_ingreso' => $data['fecha_ingreso'],
            'estado' => $data['estado'] ?? 'activo'
        ];

        if ($this->model->update($id, $barberoData)) {
            return ['success' => true, 'message' => 'Barbero actualizado correctamente'];
        }

        return ['error' => 'Error al actualizar el barbero'];
    }

    /**
     * Eliminar barbero (solo si NO tiene ventas registradas)
     */
    public function delete($id) {
        $barbero = $this->model->getById($id);
        if (!$barbero) {
            return ['error' => 'Barbero no encontrado'];
        }

        // VALIDACIÓN IMPORTANTE: Verificar si tiene ventas
        $totalVentas = $this->model->getTotalServicios($id);
        if ($totalVentas > 0) {
            return [
                'error' => 'No se puede eliminar este barbero porque tiene ventas registradas. Puede ponerlo como inactivo.'
            ];
        }

        if ($this->model->delete($id)) {
            return ['success' => true, 'message' => 'Barbero eliminado correctamente'];
        }

        return ['error' => 'Error al eliminar el barbero'];
    }

    /**
     * Cambiar estado del barbero (activo/inactivo)
     */
    public function cambiarEstado($id, $estado) {
        $barbero = $this->model->getById($id);
        if (!$barbero) {
            return ['error' => 'Barbero no encontrado'];
        }

        if (!in_array($estado, ['activo', 'inactivo'])) {
            return ['error' => 'Estado inválido'];
        }

        $data = [
            'nombre' => $barbero['nombre'],
            'apellido' => $barbero['apellido'],
            'telefono' => $barbero['telefono'],
            'fecha_ingreso' => $barbero['fecha_ingreso'],
            'estado' => $estado
        ];

        if ($this->model->update($id, $data)) {
            return ['success' => true, 'message' => 'Estado actualizado correctamente'];
        }

        return ['error' => 'Error al cambiar el estado'];
    }
}
