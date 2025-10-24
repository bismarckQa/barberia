<?php
/**
 * Controller de Servicios
 * CRUD con validación de eliminación (no se puede eliminar si tiene ventas)
 */

require_once __DIR__ . '/../models/Servicio.php';

class ServicioController {

    private $model;

    public function __construct() {
        $this->model = new Servicio();
    }

    /**
     * Listar todos los servicios
     */
    public function index() {
        return $this->model->getAll();
    }

    /**
     * Ver detalle de un servicio
     */
    public function show($id) {
        $servicio = $this->model->getById($id);
        if (!$servicio) {
            return ['error' => 'Servicio no encontrado'];
        }

        // Obtener total de veces realizado
        $totalRealizaciones = $this->model->getTotalRealizaciones($id);

        return [
            'servicio' => $servicio,
            'total_realizaciones' => $totalRealizaciones
        ];
    }

    /**
     * Crear nuevo servicio
     */
    public function store($data) {
        // Validaciones
        if (empty($data['nombre'])) {
            return ['error' => 'El nombre del servicio es obligatorio'];
        }

        if (empty($data['precio_sugerido']) || $data['precio_sugerido'] <= 0) {
            return ['error' => 'El precio debe ser mayor a 0'];
        }

        $servicioData = [
            'nombre' => trim($data['nombre']),
            'descripcion' => $data['descripcion'] ?? null,
            'precio_sugerido' => $data['precio_sugerido']
        ];

        $id = $this->model->create($servicioData);

        if ($id) {
            return ['success' => true, 'id' => $id, 'message' => 'Servicio creado correctamente'];
        }

        return ['error' => 'Error al crear el servicio'];
    }

    /**
     * Actualizar servicio
     */
    public function update($id, $data) {
        $servicio = $this->model->getById($id);
        if (!$servicio) {
            return ['error' => 'Servicio no encontrado'];
        }

        if (empty($data['nombre'])) {
            return ['error' => 'El nombre del servicio es obligatorio'];
        }

        if (empty($data['precio_sugerido']) || $data['precio_sugerido'] <= 0) {
            return ['error' => 'El precio debe ser mayor a 0'];
        }

        $servicioData = [
            'nombre' => trim($data['nombre']),
            'descripcion' => $data['descripcion'] ?? null,
            'precio_sugerido' => $data['precio_sugerido']
        ];

        if ($this->model->update($id, $servicioData)) {
            return ['success' => true, 'message' => 'Servicio actualizado correctamente'];
        }

        return ['error' => 'Error al actualizar el servicio'];
    }

    /**
     * Eliminar servicio (solo si NO tiene ventas registradas)
     */
    public function delete($id) {
        $servicio = $this->model->getById($id);
        if (!$servicio) {
            return ['error' => 'Servicio no encontrado'];
        }

        // VALIDACIÓN IMPORTANTE: Verificar si tiene ventas
        $totalRealizaciones = $this->model->getTotalRealizaciones($id);
        if ($totalRealizaciones > 0) {
            return [
                'error' => 'No se puede eliminar este servicio porque tiene ventas registradas.'
            ];
        }

        if ($this->model->delete($id)) {
            return ['success' => true, 'message' => 'Servicio eliminado correctamente'];
        }

        return ['error' => 'Error al eliminar el servicio'];
    }

    /**
     * Obtener servicios más vendidos
     */
    public function masVendidos($limit = 10) {
        return $this->model->getMasVendidos($limit);
    }
}
