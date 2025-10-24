<?php
$pageTitle = 'Nueva Cita - Sistema Barbería';
include 'includes/header.php';
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-calendar-plus"></i> Nueva Cita</h2>
                <p class="text-muted mb-0">Registrar una nueva cita</p>
            </div>
            <a href="?page=citas" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Datos de la Cita</h5>
                    </div>
                    <div class="card-body">
                        <form id="formCita">
                            <div class="row g-3">

                                <!-- Selector de tipo de cliente -->
                                <div class="col-12">
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="tipoCliente" id="tipoRegistrado" value="registrado" checked>
                                        <label class="btn btn-outline-primary" for="tipoRegistrado">
                                            <i class="bi bi-person-check"></i> Cliente Registrado
                                        </label>

                                        <input type="radio" class="btn-check" name="tipoCliente" id="tipoNuevo" value="nuevo">
                                        <label class="btn btn-outline-secondary" for="tipoNuevo">
                                            <i class="bi bi-person-plus"></i> Cliente Nuevo
                                        </label>
                                    </div>
                                </div>

                                <!-- Cliente Registrado (búsqueda con dropdown) -->
                                <div id="seccionClienteRegistrado" class="col-12">
                                    <label class="form-label" for="buscarCliente">Buscar Cliente por Nombre o Teléfono *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" id="buscarCliente" placeholder="Escribe para buscar...">
                                    </div>
                                    <input type="hidden" id="cliente_id" name="cliente_id">

                                    <!-- Dropdown de resultados -->
                                    <div id="resultadosBusqueda" class="list-group mt-2" style="max-height: 300px; overflow-y: auto; display: none;">
                                        <!-- Resultados dinámicos aquí -->
                                    </div>

                                    <!-- Cliente seleccionado -->
                                    <div id="clienteSeleccionado" class="alert alert-success mt-2" style="display: none;">
                                        <strong><i class="bi bi-person-check-fill"></i> Cliente seleccionado:</strong>
                                        <span id="nombreClienteSeleccionado"></span>
                                        <button type="button" class="btn btn-sm btn-outline-danger float-end" id="btnLimpiarSeleccion">
                                            <i class="bi bi-x"></i> Cambiar
                                        </button>
                                    </div>
                                </div>

                                <!-- Cliente Nuevo (campos manuales) -->
                                <div id="seccionClienteNuevo" style="display: none;">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="nombre_cliente">Nombre del Cliente *</label>
                                        <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente">
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="telefono">Teléfono *</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="fecha_cita">Fecha *</label>
                                    <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="hora_cita">Hora *</label>
                                    <input type="time" class="form-control" id="hora_cita" name="hora_cita" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="nota">Nota (opcional)</label>
                                    <input type="text" class="form-control" id="nota" name="nota" maxlength="100">
                                    <small class="text-muted">Máximo 100 caracteres</small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="estado">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="esperando" selected>Esperando</option>
                                        <option value="atendido">Atendido</option>
                                        <option value="no_vino">No vino</option>
                                        <option value="cancelada">Cancelada</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Guardar Cita
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

<style>
#resultadosBusqueda .list-group-item {
    cursor: pointer;
    transition: all 0.2s;
}

#resultadosBusqueda .list-group-item:hover {
    background-color: #f8f9fa;
    border-left: 4px solid #0d6efd;
}

#resultadosBusqueda {
    position: relative;
    z-index: 1000;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

#clienteSeleccionado {
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.btn-check:checked + .btn-outline-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-check:checked + .btn-outline-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}
</style>

<script>
$(document).ready(function() {
    let clienteSeleccionadoData = null;

    // Cambiar entre cliente registrado y nuevo
    $('input[name="tipoCliente"]').on('change', function() {
        const tipo = $(this).val();

        if (tipo === 'registrado') {
            $('#seccionClienteRegistrado').show();
            $('#seccionClienteNuevo').hide();
            $('#nombre_cliente').removeAttr('required');
            $('#telefono').removeAttr('required');
        } else {
            $('#seccionClienteRegistrado').hide();
            $('#seccionClienteNuevo').show();
            $('#nombre_cliente').attr('required', 'required');
            $('#telefono').attr('required', 'required');
            // Limpiar búsqueda
            limpiarBusqueda();
        }
    });

    // Búsqueda de clientes en tiempo real
    let timeoutBusqueda = null;
    $('#buscarCliente').on('keyup', function() {
        clearTimeout(timeoutBusqueda);
        const query = $(this).val().trim();

        if (query.length < 2) {
            $('#resultadosBusqueda').hide().empty();
            return;
        }

        timeoutBusqueda = setTimeout(() => {
            buscarClientes(query);
        }, 300);
    });

    function buscarClientes(query) {
        $.ajax({
            url: 'api/clientes.php?action=search&q=' + encodeURIComponent(query),
            method: 'GET',
            dataType: 'json',
            success: function(clientes) {
                mostrarResultados(clientes);
            },
            error: function() {
                showError('Error al buscar clientes');
            }
        });
    }

    function mostrarResultados(clientes) {
        const $resultados = $('#resultadosBusqueda');
        $resultados.empty();

        if (clientes.length === 0) {
            $resultados.html('<div class="list-group-item text-muted">No se encontraron clientes</div>');
            $resultados.show();
            return;
        }

        clientes.forEach(function(cliente) {
            const estado = cliente.estado === 'activo' ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>';
            const item = `
                <button type="button" class="list-group-item list-group-item-action seleccionar-cliente"
                        data-id="${cliente.id}"
                        data-nombre="${cliente.nombre}"
                        data-apellido="${cliente.apellido}"
                        data-telefono="${cliente.telefono}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${cliente.nombre} ${cliente.apellido}</strong><br>
                            <small class="text-muted"><i class="bi bi-telephone"></i> ${cliente.telefono}</small>
                        </div>
                        ${estado}
                    </div>
                </button>
            `;
            $resultados.append(item);
        });

        $resultados.show();
    }

    // Seleccionar cliente del dropdown
    $(document).on('click', '.seleccionar-cliente', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const apellido = $(this).data('apellido');
        const telefono = $(this).data('telefono');

        clienteSeleccionadoData = { id, nombre, apellido, telefono };

        $('#cliente_id').val(id);
        $('#nombreClienteSeleccionado').html(`<strong>${nombre} ${apellido}</strong> - ${telefono}`);
        $('#clienteSeleccionado').show();
        $('#resultadosBusqueda').hide();
        $('#buscarCliente').val('').prop('disabled', true);
    });

    // Limpiar selección
    $('#btnLimpiarSeleccion').on('click', function() {
        limpiarBusqueda();
    });

    function limpiarBusqueda() {
        clienteSeleccionadoData = null;
        $('#cliente_id').val('');
        $('#buscarCliente').val('').prop('disabled', false);
        $('#clienteSeleccionado').hide();
        $('#resultadosBusqueda').hide().empty();
    }

    // Enviar formulario
    $('#formCita').on('submit', function(e) {
        e.preventDefault();

        const tipoCliente = $('input[name="tipoCliente"]:checked').val();

        // Validar según tipo de cliente
        if (tipoCliente === 'registrado') {
            if (!clienteSeleccionadoData) {
                showWarning('Debes seleccionar un cliente registrado');
                return;
            }
        } else {
            if (!$('#nombre_cliente').val() || !$('#telefono').val()) {
                showWarning('Completa los datos del cliente');
                return;
            }
        }

        const formData = {
            fecha_cita: $('#fecha_cita').val(),
            hora_cita: $('#hora_cita').val(),
            nota: $('#nota').val(),
            estado: $('#estado').val()
        };

        // Agregar datos según tipo de cliente
        if (tipoCliente === 'registrado') {
            formData.nombre_cliente = clienteSeleccionadoData.nombre + ' ' + clienteSeleccionadoData.apellido;
            formData.telefono = clienteSeleccionadoData.telefono;
        } else {
            formData.nombre_cliente = $('#nombre_cliente').val();
            formData.telefono = $('#telefono').val();
        }

        ajaxRequest('api/citas.php?action=create', 'POST', formData, function(response) {
            showSuccess(response.message);
            setTimeout(() => {
                window.location.href = '?page=citas';
            }, 1500);
        });
    });
});
</script>
