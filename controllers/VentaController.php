<?php
/**
 * Controller de Ventas (CORE del sistema)
 * CRUD completo + Estadísticas
 */

require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Barbero.php';
require_once __DIR__ . '/../models/Servicio.php';

class VentaController {

    private $model;
    private $clienteModel;
    private $barberoModel;
    private $servicioModel;

    public function __construct() {
        $this->model = new Venta();
        $this->clienteModel = new Cliente();
        $this->barberoModel = new Barbero();
        $this->servicioModel = new Servicio();
    }

    /**
     * Listar todas las ventas con detalles
     */
    public function index() {
        return $this->model->getAllWithDetails();
    }

    /**
     * Ver detalle de una venta
     */
    public function show($id) {
        $venta = $this->model->getById($id);
        if (!$venta) {
            return ['error' => 'Venta no encontrada'];
        }
        return $venta;
    }

    /**
     * Registrar nueva venta (RÁPIDO - menos de 30 segundos)
     */
    public function store($data) {
        // DEBUG: Log de datos recibidos
        error_log('=== DATOS RECIBIDOS EN VENTA ===');
        error_log('Precio recibido: ' . ($data['precio'] ?? 'NO ENVIADO'));
        error_log('Servicio ID: ' . ($data['servicio_id'] ?? 'NO ENVIADO'));
        error_log('Data completa: ' . print_r($data, true));

        // Validaciones
        if (empty($data['barbero_id'])) {
            return ['error' => 'Debe seleccionar un barbero'];
        }

        if (empty($data['servicio_id'])) {
            return ['error' => 'Debe seleccionar un servicio'];
        }

        if (empty($data['precio']) || $data['precio'] <= 0) {
            return ['error' => 'El precio debe ser mayor a 0'];
        }

        // Verificar que barbero existe y está activo
        $barbero = $this->barberoModel->getById($data['barbero_id']);
        if (!$barbero || $barbero['estado'] != 'activo') {
            return ['error' => 'Barbero no válido o inactivo'];
        }

        // Verificar que servicio existe
        $servicio = $this->servicioModel->getById($data['servicio_id']);
        if (!$servicio) {
            return ['error' => 'Servicio no encontrado'];
        }

        // Cliente es opcional (puede ser NULL)
        $cliente_id = !empty($data['cliente_id']) ? $data['cliente_id'] : null;

        // Asegurarnos de que el precio es el que envió el usuario
        $precioFinal = floatval($data['precio']);

        error_log('Precio final a guardar: ' . $precioFinal);

        $ventaData = [
            'cliente_id' => $cliente_id,
            'barbero_id' => $data['barbero_id'],
            'servicio_id' => $data['servicio_id'],
            'precio' => $precioFinal,
            'metodo_pago' => $data['metodo_pago'] ?? 'efectivo',
            'nota' => $data['nota'] ?? null
        ];

        error_log('VentaData a insertar: ' . print_r($ventaData, true));

        $id = $this->model->create($ventaData);

        if ($id) {
            return ['success' => true, 'id' => $id, 'message' => 'Venta registrada correctamente', 'debug_precio' => $precioFinal];
        }

        return ['error' => 'Error al registrar la venta'];
    }

    /**
     * Actualizar venta
     */
    public function update($id, $data) {
        // Verificar que la venta existe
        $venta = $this->model->getById($id);
        if (!$venta) {
            return ['error' => 'Venta no encontrada'];
        }

        // Validaciones
        if (empty($data['barbero_id'])) {
            return ['error' => 'El barbero es obligatorio'];
        }

        if (empty($data['servicio_id'])) {
            return ['error' => 'El servicio es obligatorio'];
        }

        if (empty($data['precio']) || $data['precio'] <= 0) {
            return ['error' => 'El precio debe ser mayor a 0'];
        }

        // Preparar datos
        $updateData = [
            'cliente_id' => !empty($data['cliente_id']) ? $data['cliente_id'] : null,
            'barbero_id' => $data['barbero_id'],
            'servicio_id' => $data['servicio_id'],
            'precio' => $data['precio'],
            'metodo_pago' => $data['metodo_pago'] ?? 'efectivo',
            'nota' => $data['nota'] ?? null
        ];

        if ($this->model->update($id, $updateData)) {
            return ['success' => true, 'message' => 'Venta actualizada correctamente'];
        }

        return ['error' => 'Error al actualizar la venta'];
    }

    /**
     * Eliminar venta (solo se usa en casos de error)
     */
    public function delete($id) {
        $venta = $this->model->getById($id);
        if (!$venta) {
            return ['error' => 'Venta no encontrada'];
        }

        if ($this->model->delete($id)) {
            return ['success' => true, 'message' => 'Venta eliminada correctamente'];
        }

        return ['error' => 'Error al eliminar la venta'];
    }

    /**
     * Obtener ventas de hoy
     */
    public function ventasHoy() {
        return $this->model->getVentasHoy();
    }

    /**
     * Total de ventas de hoy (en euros)
     */
    public function totalHoy() {
        return $this->model->getTotalHoy();
    }

    /**
     * Estadísticas diarias (para gráficas)
     */
    public function estadisticasDiarias($dias = 7) {
        return $this->model->getEstadisticasDiarias($dias);
    }

    /**
     * Estadísticas semanales (para gráficas)
     */
    public function estadisticasSemanales($semanas = 4) {
        return $this->model->getEstadisticasSemanales($semanas);
    }

    /**
     * Estadísticas mensuales (para gráficas)
     */
    public function estadisticasMensuales($meses = 12) {
        return $this->model->getEstadisticasMensuales($meses);
    }

    /**
     * Ranking de barberos
     */
    public function rankingBarberos($periodo = 'mes') {
        return $this->model->getRankingBarberos($periodo);
    }

    /**
     * Métodos de pago más usados
     */
    public function metodosPagoEstadisticas() {
        return $this->model->getMetodosPagoEstadisticas();
    }

    /**
     * Datos para el formulario de nueva venta
     */
    public function formData() {
        return [
            'barberos' => $this->barberoModel->getActivos(),
            'servicios' => $this->servicioModel->getAll(),
            'clientes' => $this->clienteModel->getActivos()
        ];
    }
}
