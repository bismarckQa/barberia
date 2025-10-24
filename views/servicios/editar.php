<?php
$pageTitle = 'Editar Servicio - Sistema Barbería';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;

require_once 'controllers/ServicioController.php';
$controller = new ServicioController();
$data = $controller->show($id);

if (isset($data['error'])) {
    header('Location: ?page=servicios');
    exit;
}

$servicio = $data['servicio'];
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-pencil"></i> Editar Servicio</h2>
                <p class="text-muted mb-0"><?php echo htmlspecialchars($servicio['nombre']); ?></p>
            </div>
            <a href="?page=servicios" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Datos del Servicio</h5>
                    </div>
                    <div class="card-body">
                        <form id="formServicio">
                            <input type="hidden" id="servicio_id" value="<?php echo $servicio['id']; ?>">

                            <div class="row g-3">

                                <div class="col-12 col-md-8">
                                    <label class="form-label" for="nombre">Nombre del Servicio *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" required>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="precio_sugerido">Precio (€) *</label>
                                    <input type="number" class="form-control" id="precio_sugerido" name="precio_sugerido" value="<?php echo $servicio['precio_sugerido']; ?>" step="0.01" min="0" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo htmlspecialchars($servicio['descripcion'] ?? ''); ?></textarea>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="bi bi-save"></i> Actualizar Servicio
                                        </button>
                                        <a href="?page=servicios" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0">Estadísticas</h6>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-2"><strong>Veces realizado:</strong></p>
                        <h3 class="text-success mb-0"><?php echo $data['total_realizaciones']; ?></h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    console.log('Formulario de edición cargado');

    $('#formServicio').on('submit', function(e) {
        e.preventDefault();
        console.log('Formulario enviado');

        const nombre = $('#nombre').val().trim();
        const precio = $('#precio_sugerido').val();
        const id = $('#servicio_id').val();

        console.log('Datos:', { id, nombre, precio });

        if (!nombre) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El nombre del servicio es obligatorio'
            });
            return;
        }

        if (!precio || precio <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El precio debe ser mayor a 0'
            });
            return;
        }

        const formData = {
            id: id,
            nombre: nombre,
            descripcion: $('#descripcion').val().trim(),
            precio_sugerido: precio
        };

        console.log('Enviando datos:', formData);

        // Mostrar loading
        Swal.fire({
            title: 'Actualizando servicio...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'api/servicios.php?action=update',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                Swal.close();

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message || 'Servicio actualizado correctamente',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        console.log('Redirigiendo a servicios...');
                        window.location.href = '?page=servicios';
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Respuesta inesperada del servidor'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX:', { xhr, status, error });
                console.error('Respuesta completa:', xhr.responseText);
                Swal.close();

                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Error: ' + error,
                    footer: 'Revisa la consola para más detalles'
                });
            }
        });
    });
});
</script>
