<?php
$pageTitle = 'Nuevo Barbero - Sistema Barbería';
include 'includes/header.php';
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-person-plus"></i> Nuevo Barbero</h2>
                <p class="text-muted mb-0">Registrar un nuevo barbero/empleado</p>
            </div>
            <a href="?page=barberos" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Datos del Barbero</h5>
                    </div>
                    <div class="card-body">
                        <form id="formBarbero">
                            <div class="row g-3">

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="nombre">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="apellido">Apellido *</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="telefono">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="fecha_ingreso">Fecha de Ingreso *</label>
                                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="estado">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="activo" selected>Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Guardar Barbero
                                    </button>
                                    <a href="?page=barberos" class="btn btn-secondary">Cancelar</a>
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
    $('#formBarbero').on('submit', function(e) {
        e.preventDefault();

        if (!validateForm('formBarbero')) {
            return;
        }

        const formData = {
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            telefono: $('#telefono').val(),
            fecha_ingreso: $('#fecha_ingreso').val(),
            estado: $('#estado').val()
        };

        ajaxRequest('api/barberos.php?action=create', 'POST', formData, function(response) {
            showSuccess(response.message);
            setTimeout(() => {
                window.location.href = '?page=barberos';
            }, 1500);
        });
    });
});
</script>
