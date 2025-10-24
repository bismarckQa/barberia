<?php
$pageTitle = 'Nuevo Servicio - Sistema Barbería';
include 'includes/header.php';
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Nuevo Servicio</h2>
                <p class="text-muted mb-0">Agregar nuevo servicio al catálogo</p>
            </div>
            <a href="?page=servicios" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Datos del Servicio</h5>
                    </div>
                    <div class="card-body">
                        <form id="formServicio">
                            <div class="row g-3">

                                <div class="col-12 col-md-8">
                                    <label class="form-label" for="nombre">Nombre del Servicio *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="precio_sugerido">Precio (€) *</label>
                                    <input type="number" class="form-control" id="precio_sugerido" name="precio_sugerido" step="0.01" min="0" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Guardar Servicio
                                        </button>
                                        <a href="?page=servicios" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    $('#formServicio').on('submit', function(e) {
        e.preventDefault();

        // Validación manual
        const nombre = $('#nombre').val().trim();
        const precio = $('#precio_sugerido').val();

        if (!nombre) {
            showError('El nombre del servicio es obligatorio');
            return;
        }

        if (!precio || precio <= 0) {
            showError('El precio debe ser mayor a 0');
            return;
        }

        const formData = {
            nombre: nombre,
            descripcion: $('#descripcion').val().trim(),
            precio_sugerido: precio
        };

        // Mostrar loading
        Swal.fire({
            title: 'Guardando...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'api/servicios.php?action=create',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                Swal.close();
                if (response.success) {
                    showSuccess(response.message);
                    setTimeout(() => {
                        window.location.href = '?page=servicios';
                    }, 1500);
                } else if (response.error) {
                    showError(response.error);
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                console.error('Error:', xhr.responseText);
                showError('Error al guardar: ' + error);
            }
        });
    });
});
</script>
