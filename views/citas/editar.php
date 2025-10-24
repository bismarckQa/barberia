<?php
$pageTitle = 'Editar Cita - Sistema Barbería';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;

require_once 'controllers/CitaController.php';
$controller = new CitaController();
$cita = $controller->show($id);

if (isset($cita['error'])) {
    header('Location: ?page=citas');
    exit;
}
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-pencil"></i> Editar Cita</h2>
                <p class="text-muted mb-0"><?php echo $cita['nombre_cliente']; ?></p>
            </div>
            <a href="?page=citas" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Datos de la Cita</h5>
                    </div>
                    <div class="card-body">
                        <form id="formCita">
                            <input type="hidden" id="cita_id" value="<?php echo $cita['id']; ?>">

                            <div class="row g-3">

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="nombre_cliente">Nombre del Cliente *</label>
                                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="<?php echo $cita['nombre_cliente']; ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="telefono">Teléfono *</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $cita['telefono']; ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="fecha_cita">Fecha *</label>
                                    <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" value="<?php echo $cita['fecha_cita']; ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="hora_cita">Hora *</label>
                                    <input type="time" class="form-control" id="hora_cita" name="hora_cita" value="<?php echo $cita['hora_cita']; ?>" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="nota">Nota (opcional)</label>
                                    <input type="text" class="form-control" id="nota" name="nota" value="<?php echo $cita['nota']; ?>" maxlength="100">
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="estado">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="esperando" <?php echo $cita['estado'] == 'esperando' ? 'selected' : ''; ?>>Esperando</option>
                                        <option value="atendido" <?php echo $cita['estado'] == 'atendido' ? 'selected' : ''; ?>>Atendido</option>
                                        <option value="no_vino" <?php echo $cita['estado'] == 'no_vino' ? 'selected' : ''; ?>>No vino</option>
                                        <option value="cancelada" <?php echo $cita['estado'] == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-save"></i> Actualizar Cita
                                    </button>
                                    <a href="?page=citas" class="btn btn-secondary">Cancelar</a>
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
    $('#formCita').on('submit', function(e) {
        e.preventDefault();

        if (!validateForm('formCita')) {
            return;
        }

        const formData = {
            id: $('#cita_id').val(),
            nombre_cliente: $('#nombre_cliente').val(),
            telefono: $('#telefono').val(),
            fecha_cita: $('#fecha_cita').val(),
            hora_cita: $('#hora_cita').val(),
            nota: $('#nota').val(),
            estado: $('#estado').val()
        };

        ajaxRequest('api/citas.php?action=update', 'POST', formData, function(response) {
            showSuccess(response.message);
            setTimeout(() => {
                window.location.href = '?page=citas';
            }, 1500);
        });
    });
});
</script>
