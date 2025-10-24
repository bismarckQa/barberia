<?php
$pageTitle = 'Editar Barbero - Sistema Barbería';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;

require_once 'controllers/BarberoController.php';
$controller = new BarberoController();
$data = $controller->show($id);

if (isset($data['error'])) {
    header('Location: ?page=barberos');
    exit;
}

$barbero = $data['barbero'];
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-pencil"></i> Editar Barbero</h2>
                <p class="text-muted mb-0"><?php echo $barbero['nombre'] . ' ' . $barbero['apellido']; ?></p>
            </div>
            <a href="?page=barberos" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Datos del Barbero</h5>
                    </div>
                    <div class="card-body">
                        <form id="formBarbero">
                            <input type="hidden" id="barbero_id" value="<?php echo $barbero['id']; ?>">

                            <div class="row g-3">

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="nombre">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $barbero['nombre']; ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="apellido">Apellido *</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $barbero['apellido']; ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="telefono">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $barbero['telefono']; ?>">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="fecha_ingreso">Fecha de Ingreso *</label>
                                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $barbero['fecha_ingreso']; ?>" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="estado">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="activo" <?php echo $barbero['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                        <option value="inactivo" <?php echo $barbero['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-save"></i> Actualizar Barbero
                                    </button>
                                    <a href="?page=barberos" class="btn btn-secondary">Cancelar</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Estadísticas del barbero -->
            <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0">Estadísticas</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Servicios hoy:</strong> <?php echo $data['estadisticas']['servicios_hoy']; ?></p>
                        <p><strong>Servicios esta semana:</strong> <?php echo $data['estadisticas']['servicios_semana']; ?></p>
                        <p><strong>Servicios este mes:</strong> <?php echo $data['estadisticas']['servicios_mes']; ?></p>
                        <hr>
                        <p><strong>Total servicios:</strong> <span class="badge bg-success"><?php echo $data['estadisticas']['total_servicios']; ?></span></p>
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
            id: $('#barbero_id').val(),
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            telefono: $('#telefono').val(),
            fecha_ingreso: $('#fecha_ingreso').val(),
            estado: $('#estado').val()
        };

        ajaxRequest('api/barberos.php?action=update', 'POST', formData, function(response) {
            showSuccess(response.message);
            setTimeout(() => {
                window.location.href = '?page=barberos';
            }, 1500);
        });
    });
});
</script>
