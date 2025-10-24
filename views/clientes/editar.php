<?php
$pageTitle = 'Editar Cliente - Sistema Barbería';
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
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-pencil"></i> Editar Cliente</h2>
                <p class="text-muted mb-0"><?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?></p>
            </div>
            <a href="?page=clientes" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Datos del Cliente</h5>
                    </div>
                    <div class="card-body">
                        <form id="formCliente">
                            <input type="hidden" id="cliente_id" value="<?php echo $cliente['id']; ?>">

                            <div class="row g-3">

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="nombre">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="apellido">Apellido *</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $cliente['apellido']; ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="telefono">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="edad">Edad</label>
                                    <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $cliente['edad']; ?>" min="1" max="120">
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="notas">Notas</label>
                                    <textarea class="form-control" id="notas" name="notas" rows="3"><?php echo $cliente['notas']; ?></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="estado">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="activo" <?php echo $cliente['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                        <option value="inactivo" <?php echo $cliente['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-save"></i> Actualizar Cliente
                                    </button>
                                    <a href="?page=clientes/ver&id=<?php echo $cliente['id']; ?>" class="btn btn-secondary">Cancelar</a>
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

<script src="assets/js/validaciones-clientes.js"></script>
<script>
$(document).ready(function() {
    $('#formCliente').on('submit', function(e) {
        e.preventDefault();

        // Validar formulario completo con las nuevas validaciones
        if (!validarFormularioCliente('formCliente')) {
            return;
        }

        const formData = {
            id: $('#cliente_id').val(),
            nombre: $('#nombre').val().trim(),
            apellido: $('#apellido').val().trim(),
            telefono: $('#telefono').val().trim(),
            edad: $('#edad').val().trim(),
            notas: $('#notas').val().trim(),
            estado: $('#estado').val()
        };

        ajaxRequest('api/clientes.php?action=update', 'POST', formData, function(response) {
            showSuccess(response.message);
            setTimeout(() => {
                window.location.href = '?page=clientes/ver&id=' + $('#cliente_id').val();
            }, 1500);
        });
    });
});
</script>
