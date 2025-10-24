<?php
$pageTitle = 'Citas - Sistema Barbería';
include 'includes/header.php';

require_once 'controllers/CitaController.php';
$controller = new CitaController();
$citas = $controller->index();
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-calendar-check"></i> Citas</h2>
                <p class="text-muted mb-0">Agenda de citas programadas</p>
            </div>
            <a href="?page=citas/nueva" class="btn btn-primary">
                <i class="bi bi-calendar-plus"></i> Nueva Cita
            </a>
        </div>

        <!-- Filtro por fecha -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Buscar por Fecha:</label>
                        <input type="date" class="form-control" id="filtroFecha" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-primary w-100" id="btnFiltrar">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-secondary w-100" id="btnLimpiar">
                            <i class="bi bi-x-circle"></i> Ver Todas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaCitas" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th>Nota</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citas as $cita): ?>
                                <tr>
                                    <td><?php echo $cita['id']; ?></td>
                                    <td><strong><?php echo $cita['nombre_cliente']; ?></strong></td>
                                    <td><?php echo $cita['telefono']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($cita['fecha_cita'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($cita['hora_cita'])); ?></td>
                                    <td>
                                        <?php
                                        $badges = [
                                            'esperando' => 'warning',
                                            'atendido' => 'success',
                                            'no_vino' => 'danger',
                                            'cancelada' => 'secondary'
                                        ];
                                        $estados = [
                                            'esperando' => 'Esperando',
                                            'atendido' => 'Atendido',
                                            'no_vino' => 'No vino',
                                            'cancelada' => 'Cancelada'
                                        ];
                                        ?>
                                        <span class="badge bg-<?php echo $badges[$cita['estado']]; ?>">
                                            <?php echo $estados[$cita['estado']]; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $cita['nota'] ?? '-'; ?></td>
                                    <td>
                                        <?php if ($cita['estado'] == 'esperando'): ?>
                                            <button class="btn btn-sm btn-success btn-estado" data-id="<?php echo $cita['id']; ?>" data-estado="atendido" title="Marcar atendido">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-estado" data-id="<?php echo $cita['id']; ?>" data-estado="no_vino" title="No vino">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        <?php endif; ?>
                                        <a href="?page=citas/editar&id=<?php echo $cita['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-secondary btn-eliminar" data-id="<?php echo $cita['id']; ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    const table = initDataTable('#tablaCitas', {
        order: [[3, 'asc'], [4, 'asc']] // Ordenar por fecha y hora
    });

    // Filtrar por fecha
    $('#btnFiltrar').on('click', function() {
        const fecha = $('#filtroFecha').val();
        if (!fecha) {
            showWarning('Selecciona una fecha');
            return;
        }

        // Formatear fecha para búsqueda (dd/mm/yyyy)
        const partes = fecha.split('-');
        const fechaBusqueda = partes[2] + '/' + partes[1] + '/' + partes[0];

        table.column(3).search(fechaBusqueda).draw();
        showInfo('Mostrando citas del ' + fechaBusqueda);
    });

    // Limpiar filtro
    $('#btnLimpiar').on('click', function() {
        table.column(3).search('').draw();
        $('#filtroFecha').val('<?php echo date('Y-m-d'); ?>');
        showInfo('Mostrando todas las citas');
    });

    // Cambiar estado
    $(document).on('click', '.btn-estado', function() {
        const id = $(this).data('id');
        const estado = $(this).data('estado');

        ajaxRequest('api/citas.php?action=cambiar_estado', 'POST',
            { id: id, estado: estado },
            function(response) {
                showSuccess(response.message);
                setTimeout(() => location.reload(), 1000);
            }
        );
    });

    // Eliminar cita
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');

        confirmarEliminacion(function() {
            ajaxRequest('api/citas.php?action=delete', 'POST', { id: id }, function(response) {
                showSuccess(response.message);
                setTimeout(() => location.reload(), 1000);
            });
        });
    });
});
</script>
