<?php
$pageTitle = 'Clientes - Sistema Barbería';
include 'includes/header.php';

require_once 'controllers/ClienteController.php';
$controller = new ClienteController();
$clientes = $controller->index();
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-people"></i> Clientes</h2>
                <p class="text-muted mb-0">Gestión de clientes registrados</p>
            </div>
            <a href="?page=clientes/nuevo" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Nuevo Cliente
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaClientes" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Edad</th>
                                <th>Fecha Registro</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?php echo $cliente['id']; ?></td>
                                    <td>
                                        <strong><?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?></strong>
                                    </td>
                                    <td><?php echo $cliente['telefono'] ?? '-'; ?></td>
                                    <td><?php echo $cliente['edad'] ?? '-'; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></td>
                                    <td>
                                        <?php if ($cliente['estado'] == 'activo'): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?page=clientes/ver&id=<?php echo $cliente['id']; ?>" class="btn btn-sm btn-info" title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="?page=clientes/editar&id=<?php echo $cliente['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger btn-eliminar" data-id="<?php echo $cliente['id']; ?>" title="Eliminar">
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
    // Inicializar DataTable
    const table = initDataTable('#tablaClientes');

    // Eliminar cliente
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');

        confirmarEliminacion(function() {
            ajaxRequest('api/clientes.php?action=delete', 'POST', { id: id }, function(response) {
                showSuccess(response.message);
                setTimeout(() => location.reload(), 1000);
            });
        });
    });
});
</script>
