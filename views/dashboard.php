<?php
$pageTitle = 'Dashboard - Sistema Barbería';
include 'includes/header.php';

// Cargar controller
require_once 'controllers/DashboardController.php';
$controller = new DashboardController();
$data = $controller->index();
?>

<?php include 'includes/sidebar.php'; ?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="content-wrapper">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-house-door"></i> Dashboard</h2>
                <p class="text-muted mb-0">Vista general del negocio</p>
            </div>
            <a href="?page=ventas/nueva" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle"></i> Nueva Venta
            </a>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row g-3 g-md-4 mb-4">
            <!-- Total de hoy -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 mb-1">VENTAS HOY</p>
                                <h3><?php echo formatEuro($data['total_hoy']); ?></h3>
                            </div>
                            <i class="bi bi-cash-coin" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clientes atendidos -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 mb-1">CLIENTES HOY</p>
                                <h3><?php echo $data['clientes_hoy']; ?></h3>
                            </div>
                            <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total ventas -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 mb-1">SERVICIOS HOY</p>
                                <h3><?php echo count($data['ventas_hoy']); ?></h3>
                            </div>
                            <i class="bi bi-scissors" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Próximas citas -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 mb-1">PRÓXIMAS CITAS</p>
                                <h3><?php echo count($data['proximas_citas']); ?></h3>
                            </div>
                            <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ventas de hoy y próximas citas -->
        <div class="row g-3 g-md-4 mb-4">
            <!-- Últimas ventas de hoy -->
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt"></i> Ventas de Hoy</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($data['ventas_hoy'])): ?>
                            <p class="text-muted text-center py-4">No hay ventas registradas hoy</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Hora</th>
                                            <th>Cliente</th>
                                            <th>Servicio</th>
                                            <th>Barbero</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_slice($data['ventas_hoy'], 0, 10) as $venta): ?>
                                            <tr>
                                                <td><?php echo date('H:i', strtotime($venta['fecha_venta'])); ?></td>
                                                <td><?php echo $venta['cliente_nombre'] ? $venta['cliente_nombre'] . ' ' . $venta['cliente_apellido'] : '<span class="text-muted">Sin cliente</span>'; ?></td>
                                                <td><?php echo $venta['servicio_nombre']; ?></td>
                                                <td><?php echo $venta['barbero_nombre']; ?></td>
                                                <td><strong><?php echo formatEuro($venta['precio']); ?></strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end">
                                <a href="?page=ventas" class="btn btn-sm btn-outline-primary">Ver todas</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Próximas citas -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Próximas Citas</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($data['proximas_citas'])): ?>
                            <p class="text-muted text-center py-4">No hay citas próximas</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($data['proximas_citas'] as $cita): ?>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <strong><?php echo $cita['nombre_cliente']; ?></strong>
                                            <small class="text-muted"><?php echo date('d/m', strtotime($cita['fecha_cita'])); ?></small>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> <?php echo date('H:i', strtotime($cita['hora_cita'])); ?>
                                        </small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="text-end mt-2">
                                <a href="?page=citas" class="btn btn-sm btn-outline-primary">Ver todas</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-lightning"></i> Accesos Rápidos</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="?page=ventas/nueva" class="btn btn-success w-100 py-3">
                                    <i class="bi bi-plus-circle fs-3 d-block mb-2"></i>
                                    Nueva Venta
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="?page=citas/nueva" class="btn btn-primary w-100 py-3">
                                    <i class="bi bi-calendar-plus fs-3 d-block mb-2"></i>
                                    Nueva Cita
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="?page=clientes/nuevo" class="btn btn-info w-100 py-3">
                                    <i class="bi bi-person-plus fs-3 d-block mb-2"></i>
                                    Nuevo Cliente
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="?page=reportes" class="btn btn-warning w-100 py-3">
                                    <i class="bi bi-graph-up fs-3 d-block mb-2"></i>
                                    Ver Reportes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
// Función helper para formatear euros
function formatEuro($amount) {
    return number_format($amount, 2, ',', '.') . ' €';
}
?>

<?php include 'includes/footer.php'; ?>
