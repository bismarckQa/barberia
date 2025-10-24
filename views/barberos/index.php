<?php
$pageTitle = 'Barberos - Sistema Barbería';
include 'includes/header.php';

require_once 'controllers/BarberoController.php';
$controller = new BarberoController();
$barberos = $controller->index();
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-person-badge"></i> Barberos</h2>
                <p class="text-muted mb-0">Gestión de barberos/empleados</p>
            </div>
            <a href="?page=barberos/nuevo" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Nuevo Barbero
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaBarberos" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Fecha Ingreso</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barberos as $barbero): ?>
                                <tr>
                                    <td><?php echo $barbero['id']; ?></td>
                                    <td>
                                        <strong><?php echo $barbero['nombre'] . ' ' . $barbero['apellido']; ?></strong>
                                    </td>
                                    <td><?php echo $barbero['telefono'] ?? '-'; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($barbero['fecha_ingreso'])); ?></td>
                                    <td>
                                        <?php if ($barbero['estado'] == 'activo'): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?page=barberos/editar&id=<?php echo $barbero['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($barbero['estado'] == 'activo'): ?>
                                            <button class="btn btn-sm btn-secondary btn-inactivar" data-id="<?php echo $barbero['id']; ?>" title="Desactivar">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-success btn-activar" data-id="<?php echo $barbero['id']; ?>" title="Activar">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        <?php endif; ?>
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
    initDataTable('#tablaBarberos');

    // Inactivar barbero
    $(document).on('click', '.btn-inactivar', function() {
        const id = $(this).data('id');
        confirmarAccion('¿Desactivar este barbero?', function() {
            ajaxRequest('api/barberos.php?action=cambiar_estado', 'POST',
                { id: id, estado: 'inactivo' },
                function(response) {
                    showSuccess(response.message);
                    setTimeout(() => location.reload(), 1000);
                }
            );
        });
    });

    // Activar barbero
    $(document).on('click', '.btn-activar', function() {
        const id = $(this).data('id');
        ajaxRequest('api/barberos.php?action=cambiar_estado', 'POST',
            { id: id, estado: 'activo' },
            function(response) {
                showSuccess(response.message);
                setTimeout(() => location.reload(), 1000);
            }
        );
    });
});

function confirmarAccion(mensaje, callback) {
    Swal.fire({
        title: mensaje,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}
</script>
