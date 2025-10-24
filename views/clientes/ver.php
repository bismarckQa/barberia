<?php
$pageTitle = 'Detalle Cliente - Sistema Barbería';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;

require_once 'controllers/ClienteController.php';
$controller = new ClienteController();
$data = $controller->show($id);

if (isset($data['error'])) {
    header('Location: ?page=clientes');
    exit;
}

$cliente = $data['cliente'];
$estadisticas = $data['estadisticas'];
$historial = $data['historial'];
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1">
                    <i class="bi bi-person-circle"></i>
                    <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?>
                </h2>
                <p class="text-muted mb-0">Ficha del cliente</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="?page=clientes/editar&id=<?php echo $cliente['id']; ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="?page=clientes" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="row g-3 g-md-4">

            <!-- Información del cliente -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Información Personal</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>ID:</strong> <?php echo $cliente['id']; ?></p>
                        <p><strong>Teléfono:</strong> <?php echo $cliente['telefono'] ?? '-'; ?></p>
                        <p><strong>Edad:</strong> <?php echo $cliente['edad'] ?? '-'; ?></p>
                        <p><strong>Estado:</strong>
                            <?php if ($cliente['estado'] == 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactivo</span>
                            <?php endif; ?>
                        </p>
                        <p><strong>Registrado:</strong> <?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></p>
                        <?php if ($cliente['notas']): ?>
                            <hr>
                            <p><strong>Notas:</strong><br><?php echo nl2br($cliente['notas']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="col-12 col-lg-8">
                <div class="row g-3 mb-3 mb-md-4">
                    <div class="col-12 col-md-4">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body text-center">
                                <h3><?php echo $estadisticas['total_visitas']; ?></h3>
                                <small>Total Visitas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card stat-card bg-info text-white">
                            <div class="card-body text-center">
                                <h3><?php echo number_format($estadisticas['total_gastado'], 2); ?> €</h3>
                                <small>Total Gastado</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card stat-card bg-warning text-white">
                            <div class="card-body text-center">
                                <h3><?php echo $estadisticas['ultima_visita'] ? date('d/m/Y', strtotime($estadisticas['ultima_visita'])) : '-'; ?></h3>
                                <small>Última Visita</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Historial de visitas -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Historial de Visitas</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($historial)): ?>
                            <p class="text-muted text-center py-4">No hay historial de visitas</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Servicio</th>
                                            <th>Barbero</th>
                                            <th>Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($historial as $visita): ?>
                                            <tr>
                                                <td><?php echo date('d/m/Y H:i', strtotime($visita['fecha_venta'])); ?></td>
                                                <td><?php echo $visita['servicio_nombre']; ?></td>
                                                <td><?php echo $visita['barbero_nombre'] . ' ' . $visita['barbero_apellido']; ?></td>
                                                <td><strong><?php echo number_format($visita['precio'], 2); ?> €</strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
