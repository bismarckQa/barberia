<?php
/**
 * Controller del Dashboard (Vista principal)
 * Obtiene todos los datos necesarios para el dashboard
 */

require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Barbero.php';
require_once __DIR__ . '/../models/Servicio.php';
require_once __DIR__ . '/../models/Cita.php';

class DashboardController {

    private $ventaModel;
    private $clienteModel;
    private $barberoModel;
    private $servicioModel;
    private $citaModel;

    public function __construct() {
        $this->ventaModel = new Venta();
        $this->clienteModel = new Cliente();
        $this->barberoModel = new Barbero();
        $this->servicioModel = new Servicio();
        $this->citaModel = new Cita();
    }

    /**
     * Obtener todos los datos del dashboard
     */
    public function index() {
        // Ventas de hoy
        $ventasHoy = $this->ventaModel->getVentasHoy();
        $totalHoy = $this->ventaModel->getTotalHoy();

        // Próximas citas
        $proximasCitas = $this->citaModel->getProximas(5);

        // DEBUG: Ver qué citas se obtienen
        error_log('=== DEBUG DASHBOARD ===');
        error_log('Próximas citas obtenidas: ' . count($proximasCitas));
        error_log('Citas: ' . print_r($proximasCitas, true));

        // Clientes atendidos hoy (contar ventas únicas)
        $clientesHoy = count(array_unique(array_column($ventasHoy, 'cliente_id')));

        // Ranking de barberos (hoy)
        $rankingBarberos = $this->ventaModel->getRankingBarberos('hoy');

        // Servicios más vendidos
        $serviciosMasVendidos = $this->servicioModel->getMasVendidos(5);

        // Estadísticas de la semana (para gráfica rápida)
        $estadisticasSemana = $this->ventaModel->getEstadisticasDiarias(7);

        return [
            'ventas_hoy' => $ventasHoy,
            'total_hoy' => $totalHoy,
            'clientes_hoy' => $clientesHoy,
            'proximas_citas' => $proximasCitas,
            'ranking_barberos' => $rankingBarberos,
            'servicios_mas_vendidos' => $serviciosMasVendidos,
            'estadisticas_semana' => $estadisticasSemana
        ];
    }

    /**
     * Resumen rápido (para widgets)
     */
    public function resumen() {
        $totalHoy = $this->ventaModel->getTotalHoy();
        $ventasHoy = count($this->ventaModel->getVentasHoy());
        $citasHoy = count($this->citaModel->getCitasHoy());
        $totalClientes = count($this->clienteModel->getActivos());
        $totalBarberos = count($this->barberoModel->getActivos());

        return [
            'total_hoy' => $totalHoy,
            'ventas_hoy' => $ventasHoy,
            'citas_hoy' => $citasHoy,
            'total_clientes' => $totalClientes,
            'total_barberos' => $totalBarberos
        ];
    }
}
