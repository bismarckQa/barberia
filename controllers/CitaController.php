<?php
/**
 * Controller de Citas
 * CRUD completo
 */

require_once __DIR__ . '/../models/Cita.php';

class CitaController {

    private $model;

    public function __construct() {
        $this->model = new Cita();
    }

    /**
     * Listar todas las citas
     */
    public function index() {
        return $this->model->getAll();
    }

    /**
     * Ver detalle de una cita
     */
    public function show($id) {
        $cita = $this->model->getById($id);
        if (!$cita) {
            return ['error' => 'Cita no encontrada'];
        }
        return $cita;
    }

    /**
     * Crear nueva cita
     */
    public function store($data) {
        // Validaciones
        if (empty($data['nombre_cliente'])) {
            return ['error' => 'El nombre del cliente es obligatorio'];
        }

        if (empty($data['telefono'])) {
            return ['error' => 'El teléfono es obligatorio'];
        }

        if (empty($data['fecha_cita']) || empty($data['hora_cita'])) {
            return ['error' => 'Fecha y hora son obligatorias'];
        }

        $citaData = [
            'nombre_cliente' => trim($data['nombre_cliente']),
            'telefono' => trim($data['telefono']),
            'fecha_cita' => $data['fecha_cita'],
            'hora_cita' => $data['hora_cita'],
            'nota' => $data['nota'] ?? null,
            'estado' => $data['estado'] ?? 'esperando'
        ];

        $id = $this->model->create($citaData);

        if ($id) {
            return ['success' => true, 'id' => $id, 'message' => 'Cita registrada correctamente'];
        }

        return ['error' => 'Error al registrar la cita'];
    }

    /**
     * Actualizar cita
     */
    public function update($id, $data) {
        $cita = $this->model->getById($id);
        if (!$cita) {
            return ['error' => 'Cita no encontrada'];
        }

        if (empty($data['nombre_cliente'])) {
            return ['error' => 'El nombre del cliente es obligatorio'];
        }

        if (empty($data['telefono'])) {
            return ['error' => 'El teléfono es obligatorio'];
        }

        if (empty($data['fecha_cita']) || empty($data['hora_cita'])) {
            return ['error' => 'Fecha y hora son obligatorias'];
        }

        $citaData = [
            'nombre_cliente' => trim($data['nombre_cliente']),
            'telefono' => trim($data['telefono']),
            'fecha_cita' => $data['fecha_cita'],
            'hora_cita' => $data['hora_cita'],
            'nota' => $data['nota'] ?? null,
            'estado' => $data['estado'] ?? 'esperando'
        ];

        if ($this->model->update($id, $citaData)) {
            return ['success' => true, 'message' => 'Cita actualizada correctamente'];
        }

        return ['error' => 'Error al actualizar la cita'];
    }

    /**
     * Eliminar cita
     */
    public function delete($id) {
        $cita = $this->model->getById($id);
        if (!$cita) {
            return ['error' => 'Cita no encontrada'];
        }

        if ($this->model->delete($id)) {
            return ['success' => true, 'message' => 'Cita eliminada correctamente'];
        }

        return ['error' => 'Error al eliminar la cita'];
    }

    /**
     * Obtener citas de hoy
     */
    public function citasHoy() {
        return $this->model->getCitasHoy();
    }

    /**
     * Obtener citas por fecha
     */
    public function citasPorFecha($fecha) {
        return $this->model->getCitasPorFecha($fecha);
    }

    /**
     * Obtener próximas citas
     */
    public function proximas($limit = 10) {
        return $this->model->getProximas($limit);
    }

    /**
     * Cambiar estado de la cita
     */
    public function cambiarEstado($id, $estado) {
        $cita = $this->model->getById($id);
        if (!$cita) {
            return ['error' => 'Cita no encontrada'];
        }

        if (!in_array($estado, ['esperando', 'atendido', 'no_vino', 'cancelada'])) {
            return ['error' => 'Estado inválido'];
        }

        if ($this->model->cambiarEstado($id, $estado)) {
            return ['success' => true, 'message' => 'Estado actualizado correctamente'];
        }

        return ['error' => 'Error al cambiar el estado'];
    }
}
