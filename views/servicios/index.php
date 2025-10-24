<?php
$pageTitle = 'Servicios - Sistema Barbería';
include 'includes/header.php';

require_once 'controllers/ServicioController.php';
$controller = new ServicioController();
$servicios = $controller->index();
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-list-check"></i> Servicios</h2>
                <p class="text-muted mb-0">Catálogo de servicios ofrecidos</p>
            </div>
            <a href="?page=servicios/nuevo" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Servicio
            </a>
        </div>

        <div class="servicios-grid">
            <?php foreach ($servicios as $servicio): ?>
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0"><?php echo htmlspecialchars($servicio['nombre']); ?></h5>
                            <h4 class="text-success mb-0"><?php echo number_format($servicio['precio_sugerido'], 2); ?> €</h4>
                        </div>
                        <p class="card-text text-muted small flex-grow-1">
                            <?php echo htmlspecialchars($servicio['descripcion'] ?? 'Sin descripción'); ?>
                        </p>
                        <div class="d-flex gap-2 mt-3">
                            <a href="?page=servicios/editar&id=<?php echo $servicio['id']; ?>" class="btn btn-sm btn-warning flex-fill">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <button class="btn btn-sm btn-danger flex-fill btn-eliminar" data-id="<?php echo $servicio['id']; ?>">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Eliminar servicio
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');
        const btn = $(this);

        Swal.fire({
            title: '¿Eliminar servicio?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/servicios.php?action=delete',
                    method: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            setTimeout(() => location.reload(), 1000);
                        } else if (response.error) {
                            showError(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        showError('Error al eliminar: ' + error);
                    }
                });
            }
        });
    });
});
</script>
