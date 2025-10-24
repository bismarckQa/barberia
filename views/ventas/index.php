<?php
$pageTitle = 'Ventas - Sistema Barbería';
include 'includes/header.php';

require_once 'controllers/VentaController.php';
$controller = new VentaController();
$ventas = $controller->index();
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-receipt"></i> Ventas</h2>
                <p class="text-muted mb-0">Historial de todas las ventas</p>
            </div>
            <a href="?page=ventas/nueva" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Nueva Venta
            </a>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3 align-items-end mb-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label mb-1">Filtros Rápidos:</label>
                        <select class="form-select" id="filtroRango">
                            <option value="">Todas las fechas</option>
                            <option value="hoy">Hoy</option>
                            <option value="ayer">Ayer</option>
                            <option value="semana">Esta semana</option>
                            <option value="mes">Este mes</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <button class="btn btn-secondary w-100" id="btnLimpiar">
                            <i class="bi bi-x-circle"></i> Ver Todas
                        </button>
                    </div>
                    <div class="col-12 col-md-2">
                        <button class="btn btn-info w-100" id="btnEstadisticas">
                            <i class="bi bi-calculator"></i> Totales
                        </button>
                    </div>
                </div>

                <!-- Filtro por rango personalizado -->
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="form-label mb-1"><i class="bi bi-calendar-range"></i> Desde:</label>
                        <input type="date" class="form-control" id="fechaDesde">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label mb-1"><i class="bi bi-calendar-check"></i> Hasta:</label>
                        <input type="date" class="form-control" id="fechaHasta" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-primary w-100" id="btnFiltrarRango">
                            <i class="bi bi-funnel"></i> Filtrar por Rango
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaVentas" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Barbero</th>
                                <th>Servicio</th>
                                <th>Precio</th>
                                <th>Método Pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta): ?>
                                <tr>
                                    <td><?php echo $venta['id']; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($venta['fecha_venta'])); ?></td>
                                    <td>
                                        <?php if ($venta['cliente_nombre']): ?>
                                            <a href="?page=clientes/ver&id=<?php echo $venta['cliente_id']; ?>">
                                                <?php echo $venta['cliente_nombre'] . ' ' . $venta['cliente_apellido']; ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Sin cliente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $venta['barbero_nombre'] . ' ' . $venta['barbero_apellido']; ?></td>
                                    <td><?php echo $venta['servicio_nombre']; ?></td>
                                    <td><strong><?php echo number_format($venta['precio'], 2) . ' €'; ?></strong></td>
                                    <td>
                                        <?php
                                        $badges = [
                                            'efectivo' => 'success',
                                            'tarjeta' => 'primary',
                                            'transferencia' => 'info',
                                            'otro' => 'secondary'
                                        ];
                                        ?>
                                        <span class="badge bg-<?php echo $badges[$venta['metodo_pago']]; ?>">
                                            <?php echo ucfirst($venta['metodo_pago']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="?page=ventas/editar&id=<?php echo $venta['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger btn-eliminar" data-id="<?php echo $venta['id']; ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Variable global para almacenar filtro custom
    let filtroActivo = null;

    // Inicializar DataTable con ordenamiento por fecha descendente
    const table = initDataTable('#tablaVentas', {
        order: [[1, 'desc']] // Ordenar por fecha (columna 1) descendente
    });

    // Cambio en selector de rango rápido
    $('#filtroRango').on('change', function() {
        const rango = $(this).val();

        if (rango) {
            // Limpiar campos de rango personalizado
            $('#fechaDesde').val('');
            $('#fechaHasta').val('<?php echo date('Y-m-d'); ?>');
            filtrarPorRango(rango);
        }
    });

    // Filtrar por rango personalizado (Desde - Hasta)
    $('#btnFiltrarRango').on('click', function() {
        const fechaDesde = $('#fechaDesde').val();
        const fechaHasta = $('#fechaHasta').val();

        if (!fechaDesde || !fechaHasta) {
            showWarning('Debes seleccionar ambas fechas (Desde y Hasta)');
            return;
        }

        // Validar que la fecha desde sea menor o igual a fecha hasta
        if (new Date(fechaDesde) > new Date(fechaHasta)) {
            showWarning('La fecha "Desde" no puede ser mayor que la fecha "Hasta"');
            return;
        }

        // Limpiar selector de filtros rápidos
        $('#filtroRango').val('');

        filtrarPorRangoPersonalizado(fechaDesde, fechaHasta);
    });

    // Limpiar filtros
    $('#btnLimpiar').on('click', function() {
        // Limpiar filtro custom si existe
        limpiarFiltroCustom();

        table.column(1).search('').draw();
        $('#filtroRango').val('');
        $('#fechaDesde').val('');
        $('#fechaHasta').val('<?php echo date('Y-m-d'); ?>');
        showInfo('Mostrando todas las ventas');
    });

    // Mostrar estadísticas de ventas filtradas
    $('#btnEstadisticas').on('click', function() {
        const ventasVisibles = table.rows({ search: 'applied' }).data();
        let totalVentas = ventasVisibles.length;
        let totalIngresos = 0;

        // Calcular total de ingresos de las ventas visibles
        ventasVisibles.each(function(value, index) {
            // Obtener el precio de la columna 5 (índice 5)
            const precioTexto = $(value[5]).text().trim();
            const precio = parseFloat(precioTexto.replace(' €', '').replace(',', '.'));
            if (!isNaN(precio)) {
                totalIngresos += precio;
            }
        });

        // Mostrar modal con estadísticas
        Swal.fire({
            title: '📊 Estadísticas de Ventas Filtradas',
            html: `
                <div class="text-start">
                    <p class="mb-2"><strong>Total de ventas:</strong> ${totalVentas}</p>
                    <p class="mb-2"><strong>Ingresos totales:</strong> <span class="text-success">${totalIngresos.toFixed(2)} €</span></p>
                    <p class="mb-0"><strong>Promedio por venta:</strong> ${totalVentas > 0 ? (totalIngresos / totalVentas).toFixed(2) : '0.00'} €</p>
                </div>
            `,
            icon: 'info',
            confirmButtonText: 'Cerrar'
        });
    });

    function limpiarFiltroCustom() {
        if (filtroActivo !== null) {
            $.fn.dataTable.ext.search.splice(filtroActivo, 1);
            filtroActivo = null;
        }
    }

    function filtrarPorRangoPersonalizado(fechaDesde, fechaHasta) {
        // Limpiar filtro custom anterior primero
        limpiarFiltroCustom();

        // Limpiar búsqueda de columna
        table.column(1).search('');

        // Convertir fechas a formato comparable YYYYMMDD (sin Date object)
        const desdeNum = parseInt(fechaDesde.replace(/-/g, '')); // 20240801
        const hastaNum = parseInt(fechaHasta.replace(/-/g, '')); // 20241024

        console.log('=== DEBUG FILTRO ===');
        console.log('Fecha desde:', fechaDesde, '→', desdeNum);
        console.log('Fecha hasta:', fechaHasta, '→', hastaNum);

        // Crear filtro custom
        const filtro = function(settings, data, dataIndex) {
            try {
                const fechaVentaStr = data[1]; // Columna fecha (formato: DD/MM/YYYY HH:MM)

                if (!fechaVentaStr) {
                    console.log('Fila sin fecha');
                    return false;
                }

                // Extraer solo la fecha (sin hora): "15/08/2024 10:30" → "15/08/2024"
                const soloFecha = fechaVentaStr.trim().split(' ')[0];
                const partes = soloFecha.split('/'); // ["15", "08", "2024"]

                if (partes.length !== 3) {
                    console.log('Fecha mal formateada:', fechaVentaStr);
                    return false;
                }

                // Convertir DD/MM/YYYY a YYYYMMDD para comparar números
                const ventaNum = parseInt(partes[2] + partes[1] + partes[0]); // 20240815

                const dentroRango = ventaNum >= desdeNum && ventaNum <= hastaNum;

                // Log solo las primeras 3 filas para no saturar consola
                if (dataIndex < 3) {
                    console.log(`Fila ${dataIndex}: ${soloFecha} → ${ventaNum} | En rango: ${dentroRango}`);
                }

                return dentroRango;
            } catch (e) {
                console.error('Error procesando fecha:', e);
                return false;
            }
        };

        $.fn.dataTable.ext.search.push(filtro);
        filtroActivo = $.fn.dataTable.ext.search.length - 1;

        table.draw();

        // Contar resultados filtrados
        const resultados = table.rows({ search: 'applied' }).count();
        console.log('✅ Total de registros encontrados:', resultados);
        console.log('===================');

        // Formatear fechas para mostrar
        const partesDesde = fechaDesde.split('-');
        const desdeFormato = `${partesDesde[2]}/${partesDesde[1]}/${partesDesde[0]}`;

        const partesHasta = fechaHasta.split('-');
        const hastaFormato = `${partesHasta[2]}/${partesHasta[1]}/${partesHasta[0]}`;

        if (resultados > 0) {
            showInfo(`Mostrando ${resultados} ventas desde ${desdeFormato} hasta ${hastaFormato}`);
        } else {
            showWarning(`No se encontraron ventas desde ${desdeFormato} hasta ${hastaFormato}`);
        }
    }

    function filtrarPorRango(rango) {
        // Limpiar filtro custom anterior
        limpiarFiltroCustom();

        const hoy = new Date();
        let fechaBusqueda = '';

        switch(rango) {
            case 'hoy':
                fechaBusqueda = formatearFecha(new Date());
                break;

            case 'ayer':
                const ayer = new Date();
                ayer.setDate(ayer.getDate() - 1);
                fechaBusqueda = formatearFecha(ayer);
                break;

            case 'semana':
                filtrarPorSemana();
                return;

            case 'mes':
                filtrarPorMes();
                return;
        }

        if (fechaBusqueda) {
            table.column(1).search(fechaBusqueda).draw();
            showInfo('Mostrando ventas: ' + rango);
        }
    }

    function filtrarPorSemana() {
        // Limpiar búsqueda de columna
        table.column(1).search('').draw();

        const ahora = new Date();
        const diaSemana = ahora.getDay();
        const diasDesdeL = diaSemana === 0 ? 6 : diaSemana - 1; // Lunes como primer día

        const primerDia = new Date(ahora);
        primerDia.setDate(ahora.getDate() - diasDesdeL);
        primerDia.setHours(0, 0, 0, 0);

        const ultimoDia = new Date();
        ultimoDia.setHours(23, 59, 59, 999);

        // Crear filtro custom
        const filtro = function(settings, data, dataIndex) {
            const fechaVentaStr = data[1]; // Columna fecha
            const partes = fechaVentaStr.split(' ')[0].split('/'); // Obtener solo fecha, sin hora
            const fechaVenta = new Date(partes[2], partes[1] - 1, partes[0]);
            fechaVenta.setHours(0, 0, 0, 0);

            return fechaVenta >= primerDia && fechaVenta <= ultimoDia;
        };

        $.fn.dataTable.ext.search.push(filtro);
        filtroActivo = $.fn.dataTable.ext.search.length - 1;

        table.draw();
        showInfo('Mostrando ventas de esta semana');
    }

    function filtrarPorMes() {
        // Limpiar filtro custom anterior
        limpiarFiltroCustom();

        const hoy = new Date();
        const mesActual = (hoy.getMonth() + 1).toString().padStart(2, '0');
        const añoActual = hoy.getFullYear();

        // Buscar por patrón mes/año
        const patron = '/' + mesActual + '/' + añoActual;
        table.column(1).search(patron).draw();
        showInfo('Mostrando ventas de este mes');
    }

    function formatearFecha(fecha) {
        const dia = fecha.getDate().toString().padStart(2, '0');
        const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
        const año = fecha.getFullYear();
        return dia + '/' + mes + '/' + año;
    }

    // Eliminar venta
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');

        confirmarEliminacion(function() {
            ajaxRequest('api/ventas.php?action=delete', 'POST', { id: id }, function(response) {
                showSuccess(response.message);
                setTimeout(() => location.reload(), 1000);
            });
        });
    });
});
</script>
