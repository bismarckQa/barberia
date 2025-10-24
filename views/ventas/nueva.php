<?php
$pageTitle = 'Nueva Venta - Sistema Barbería';
include 'includes/header.php';

// Cargar datos del formulario
require_once 'controllers/VentaController.php';
$controller = new VentaController();
$formData = $controller->formData();
?>

<?php include 'includes/sidebar.php'; ?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="content-wrapper">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-cash-stack"></i> Nueva Venta</h2>
                <p class="text-muted mb-0">Registro rápido de venta (menos de 30 segundos)</p>
            </div>
            <a href="?page=ventas" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <!-- Formulario de venta -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt"></i> Formulario de Venta</h5>
                    </div>
                    <div class="card-body">
                        <form id="formVenta">
                            <div class="row g-3">

                                <!-- Barbero -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="barbero_id">
                                        <i class="bi bi-person-badge"></i> Barbero *
                                    </label>
                                    <select class="form-select" id="barbero_id" name="barbero_id" required>
                                        <option value="">Seleccionar barbero</option>
                                        <?php foreach ($formData['barberos'] as $barbero): ?>
                                            <option value="<?php echo $barbero['id']; ?>">
                                                <?php echo $barbero['nombre'] . ' ' . $barbero['apellido']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Servicio -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="servicio_id">
                                        <i class="bi bi-scissors"></i> Servicio *
                                    </label>
                                    <select class="form-select" id="servicio_id" name="servicio_id" required>
                                        <option value="">Seleccionar servicio</option>
                                        <?php foreach ($formData['servicios'] as $servicio): ?>
                                            <option value="<?php echo $servicio['id']; ?>" data-precio="<?php echo $servicio['precio_sugerido']; ?>">
                                                <?php echo $servicio['nombre'] . ' (' . number_format($servicio['precio_sugerido'], 2) . ' €)'; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Cliente (opcional) -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="cliente_id">
                                        <i class="bi bi-person"></i> Cliente (opcional)
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="buscar_cliente" placeholder="Buscar por nombre o teléfono">
                                        <button class="btn btn-outline-secondary" type="button" id="btnBuscarCliente">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" id="cliente_id" name="cliente_id">
                                    <small class="text-muted">Deja en blanco si es cliente sin registrar</small>
                                    <div id="clienteSeleccionado" class="mt-2"></div>
                                </div>

                                <!-- Precio -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="precio">
                                        <i class="bi bi-currency-euro"></i> Precio *
                                    </label>
                                    <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required>
                                </div>

                                <!-- Método de pago -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="metodo_pago">
                                        <i class="bi bi-wallet2"></i> Método de Pago
                                    </label>
                                    <select class="form-select" id="metodo_pago" name="metodo_pago">
                                        <option value="efectivo" selected>Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>

                                <!-- Nota -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="nota">
                                        <i class="bi bi-sticky"></i> Nota (opcional)
                                    </label>
                                    <input type="text" class="form-control" id="nota" name="nota" maxlength="100" placeholder="Observación breve">
                                </div>

                                <!-- Botones -->
                                <div class="col-12">
                                    <hr>
                                    <button type="submit" class="btn btn-success btn-lg w-100">
                                        <i class="bi bi-check-circle"></i> Registrar Venta
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Panel lateral con info -->
            <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                <!-- Resumen -->
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="bi bi-info-circle"></i> Resumen</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Barbero:</small>
                            <div id="resumen_barbero" class="fw-bold">-</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Servicio:</small>
                            <div id="resumen_servicio" class="fw-bold">-</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Cliente:</small>
                            <div id="resumen_cliente" class="fw-bold">Sin cliente</div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total:</span>
                            <h3 class="mb-0 text-success" id="resumen_total">0.00 €</h3>
                        </div>
                    </div>
                </div>

                <!-- Atajos de teclado -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-keyboard"></i> Ayuda</h6>
                    </div>
                    <div class="card-body">
                        <small>
                            <ul class="list-unstyled mb-0">
                                <li><i class="bi bi-check-circle text-success"></i> Campos con * son obligatorios</li>
                                <li><i class="bi bi-person text-info"></i> Cliente es opcional</li>
                                <li><i class="bi bi-cash text-warning"></i> Precio se autocompleta</li>
                                <li><i class="bi bi-lightning text-danger"></i> Registro en 30 seg</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal búsqueda de cliente -->
<div class="modal fade" id="modalBuscarCliente" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-search"></i> Buscar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-3" id="buscarClienteModal" placeholder="Nombre o teléfono...">
                <div id="resultadosBusqueda"></div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {

    // Autocompletar precio al seleccionar servicio
    $('#servicio_id').on('change', function() {
        const precioSugerido = $(this).find(':selected').data('precio');
        $('#precio').val(precioSugerido);
        actualizarResumen();
    });

    // Actualizar resumen en tiempo real
    $('#barbero_id, #servicio_id, #precio').on('change keyup', function() {
        actualizarResumen();
    });

    function actualizarResumen() {
        const barbero = $('#barbero_id option:selected').text();
        const servicio = $('#servicio_id option:selected').text();
        const precio = parseFloat($('#precio').val()) || 0;

        $('#resumen_barbero').text(barbero || '-');
        $('#resumen_servicio').text(servicio || '-');
        $('#resumen_total').text(precio.toFixed(2) + ' €');
    }

    // Búsqueda de cliente
    $('#btnBuscarCliente').on('click', function() {
        $('#modalBuscarCliente').modal('show');
    });

    // Búsqueda en tiempo real
    let timeout = null;
    $('#buscarClienteModal').on('keyup', function() {
        clearTimeout(timeout);
        const query = $(this).val();

        if (query.length >= 2) {
            timeout = setTimeout(() => {
                buscarCliente(query);
            }, 500);
        } else {
            $('#resultadosBusqueda').html('');
        }
    });

    function buscarCliente(query) {
        $.ajax({
            url: 'api/clientes.php?action=search',
            method: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function(response) {
                if (response.length > 0) {
                    let html = '<div class="list-group">';
                    response.forEach(cliente => {
                        html += `
                            <a href="#" class="list-group-item list-group-item-action seleccionar-cliente"
                               data-id="${cliente.id}"
                               data-nombre="${cliente.nombre} ${cliente.apellido}">
                                <strong>${cliente.nombre} ${cliente.apellido}</strong><br>
                                <small class="text-muted">${cliente.telefono || 'Sin teléfono'}</small>
                            </a>
                        `;
                    });
                    html += '</div>';
                    $('#resultadosBusqueda').html(html);
                } else {
                    $('#resultadosBusqueda').html('<p class="text-muted text-center">No se encontraron clientes</p>');
                }
            }
        });
    }

    // Seleccionar cliente
    $(document).on('click', '.seleccionar-cliente', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');

        $('#cliente_id').val(id);
        $('#clienteSeleccionado').html(`
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-check-circle"></i> <strong>${nombre}</strong>
                <button type="button" class="btn-close" onclick="limpiarCliente()"></button>
            </div>
        `);
        $('#resumen_cliente').text(nombre);
        $('#modalBuscarCliente').modal('hide');
    });

    // Limpiar cliente
    window.limpiarCliente = function() {
        $('#cliente_id').val('');
        $('#clienteSeleccionado').html('');
        $('#resumen_cliente').text('Sin cliente');
    };

    // Enviar formulario
    $('#formVenta').on('submit', function(e) {
        e.preventDefault();

        if (!validateForm('formVenta')) {
            return;
        }

        // Obtener el precio del campo input directamente
        const precioFinal = parseFloat($('#precio').val());

        console.log('Precio del input:', precioFinal);
        console.log('Valor del campo precio:', $('#precio').val());

        const formData = {
            barbero_id: $('#barbero_id').val(),
            servicio_id: $('#servicio_id').val(),
            cliente_id: $('#cliente_id').val() || null,
            precio: precioFinal,
            metodo_pago: $('#metodo_pago').val(),
            nota: $('#nota').val()
        };

        console.log('FormData completo enviado:', formData);

        ajaxRequest('api/ventas.php?action=create', 'POST', formData, function(response) {
            console.log('Respuesta del servidor:', response);
            showSuccess(response.message);
            clearForm('formVenta');
            limpiarCliente();
            actualizarResumen();

            // Redirigir al dashboard después de 1 segundo
            setTimeout(() => {
                window.location.href = '?page=dashboard';
            }, 1500);
        });
    });

});
</script>
