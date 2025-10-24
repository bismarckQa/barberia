<?php
$pageTitle = 'Editar Venta - Sistema Barbería';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;

require_once 'controllers/VentaController.php';
require_once 'controllers/ClienteController.php';
require_once 'controllers/BarberoController.php';
require_once 'controllers/ServicioController.php';

$ventaController = new VentaController();
$clienteController = new ClienteController();
$barberoController = new BarberoController();
$servicioController = new ServicioController();

$venta = $ventaController->show($id);

if (isset($venta['error'])) {
    header('Location: ?page=ventas');
    exit;
}

$clientes = $clienteController->index();
$barberos = $barberoController->index();
$servicios = $servicioController->index();
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-pencil-square"></i> Editar Venta</h2>
                <p class="text-muted mb-0">Modificar información de la venta #<?php echo $venta['id']; ?></p>
            </div>
            <a href="?page=ventas" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row g-3 g-md-4">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Datos de la Venta</h5>
                    </div>
                    <div class="card-body">
                        <form id="formEditarVenta">
                            <input type="hidden" id="venta_id" value="<?php echo $venta['id']; ?>">

                            <div class="row g-3">
                                <!-- Cliente -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Cliente <small class="text-muted">(Opcional)</small></label>
                                    <select class="form-select" id="cliente_id">
                                        <option value="">Sin cliente (walk-in)</option>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?php echo $cliente['id']; ?>"
                                                <?php echo ($venta['cliente_id'] == $cliente['id']) ? 'selected' : ''; ?>>
                                                <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Barbero -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Barbero <span class="text-danger">*</span></label>
                                    <select class="form-select" id="barbero_id" required>
                                        <option value="">Seleccionar...</option>
                                        <?php foreach ($barberos as $barbero): ?>
                                            <option value="<?php echo $barbero['id']; ?>"
                                                <?php echo ($venta['barbero_id'] == $barbero['id']) ? 'selected' : ''; ?>>
                                                <?php echo $barbero['nombre'] . ' ' . $barbero['apellido']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Servicio -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Servicio <span class="text-danger">*</span></label>
                                    <select class="form-select" id="servicio_id" required>
                                        <option value="">Seleccionar...</option>
                                        <?php foreach ($servicios as $servicio): ?>
                                            <option value="<?php echo $servicio['id']; ?>"
                                                data-precio="<?php echo $servicio['precio_sugerido']; ?>"
                                                <?php echo ($venta['servicio_id'] == $servicio['id']) ? 'selected' : ''; ?>>
                                                <?php echo $servicio['nombre']; ?> (<?php echo number_format($servicio['precio_sugerido'], 2); ?> €)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Precio -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Precio <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="precio"
                                            value="<?php echo $venta['precio']; ?>"
                                            step="0.01" min="0" max="9999" required>
                                        <span class="input-group-text">€</span>
                                    </div>
                                    <small class="text-muted">Precio final cobrado al cliente</small>
                                </div>

                                <!-- Método de Pago -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Método de Pago <span class="text-danger">*</span></label>
                                    <select class="form-select" id="metodo_pago" required>
                                        <option value="efectivo" <?php echo ($venta['metodo_pago'] == 'efectivo') ? 'selected' : ''; ?>>💵 Efectivo</option>
                                        <option value="tarjeta" <?php echo ($venta['metodo_pago'] == 'tarjeta') ? 'selected' : ''; ?>>💳 Tarjeta</option>
                                        <option value="transferencia" <?php echo ($venta['metodo_pago'] == 'transferencia') ? 'selected' : ''; ?>>🏦 Transferencia</option>
                                        <option value="otro" <?php echo ($venta['metodo_pago'] == 'otro') ? 'selected' : ''; ?>>📱 Otro</option>
                                    </select>
                                </div>

                                <!-- Nota -->
                                <div class="col-12">
                                    <label class="form-label">Nota <small class="text-muted">(Opcional)</small></label>
                                    <textarea class="form-control" id="nota" rows="2"
                                        placeholder="Comentarios adicionales..."><?php echo $venta['nota'] ?? ''; ?></textarea>
                                </div>

                                <!-- Fecha de Venta (info) -->
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">
                                        <i class="bi bi-info-circle"></i>
                                        <strong>Fecha original:</strong> <?php echo date('d/m/Y H:i', strtotime($venta['fecha_venta'])); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4 flex-wrap">
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-save"></i> Actualizar Venta
                                </button>
                                <a href="?page=ventas" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>ID Venta:</strong> #<?php echo $venta['id']; ?></p>
                        <p><strong>Registrada:</strong> <?php echo date('d/m/Y H:i', strtotime($venta['fecha_venta'])); ?></p>
                        <hr>
                        <p class="text-muted mb-0"><small>
                            <i class="bi bi-exclamation-triangle"></i>
                            Ten cuidado al editar ventas, esto afectará las estadísticas y reportes.
                        </small></p>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-calculator"></i> Resumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Servicio:</span>
                            <span id="resumenServicio" class="fw-bold">-</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Precio:</span>
                            <span id="resumenPrecio" class="fw-bold text-success">-</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Método:</span>
                            <span id="resumenMetodo" class="fw-bold">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Cuando cambie el servicio, actualizar precio sugerido
    $('#servicio_id').on('change', function() {
        const precioSugerido = $(this).find('option:selected').data('precio');
        if (precioSugerido) {
            $('#precio').val(parseFloat(precioSugerido).toFixed(2));
        }
        actualizarResumen();
    });

    // Actualizar resumen en tiempo real
    $('#servicio_id, #precio, #metodo_pago').on('change keyup', function() {
        actualizarResumen();
    });

    // Actualizar resumen inicial
    actualizarResumen();

    function actualizarResumen() {
        const servicioNombre = $('#servicio_id option:selected').text().split(' (')[0];
        const precio = parseFloat($('#precio').val()) || 0;
        const metodoPago = $('#metodo_pago option:selected').text();

        $('#resumenServicio').text(servicioNombre || '-');
        $('#resumenPrecio').text(precio.toFixed(2) + ' €');
        $('#resumenMetodo').text(metodoPago || '-');
    }

    // Enviar formulario
    $('#formEditarVenta').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            id: $('#venta_id').val(),
            cliente_id: $('#cliente_id').val() || null,
            barbero_id: $('#barbero_id').val(),
            servicio_id: $('#servicio_id').val(),
            precio: parseFloat($('#precio').val()),
            metodo_pago: $('#metodo_pago').val(),
            nota: $('#nota').val()
        };

        // Validaciones
        if (!formData.barbero_id) {
            showError('Selecciona un barbero');
            return;
        }

        if (!formData.servicio_id) {
            showError('Selecciona un servicio');
            return;
        }

        if (!formData.precio || formData.precio <= 0) {
            showError('Ingresa un precio válido');
            return;
        }

        // Enviar datos
        ajaxRequest('api/ventas.php?action=update', 'POST', formData, function(response) {
            showSuccess(response.message);
            setTimeout(() => {
                window.location.href = '?page=ventas';
            }, 1500);
        });
    });
});
</script>
