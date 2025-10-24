<?php
$pageTitle = 'Reportes y Estadísticas - Sistema Barbería';
include 'includes/header.php';

require_once 'controllers/VentaController.php';
require_once 'controllers/ServicioController.php';

$ventaController = new VentaController();
$servicioController = new ServicioController();

// Obtener datos para gráficas
$estadisticasDiarias = $ventaController->estadisticasDiarias(30); // Últimos 30 días
$estadisticasSemanales = $ventaController->estadisticasSemanales(8); // Últimas 8 semanas
$estadisticasMensuales = $ventaController->estadisticasMensuales(6); // Últimos 6 meses
$rankingBarberos = $ventaController->rankingBarberos('mes');
$serviciosMasVendidos = $servicioController->masVendidos(5);
$metodosPago = $ventaController->metodosPagoEstadisticas();
?>

<?php include 'includes/sidebar.php'; ?>

<div id="page-content-wrapper">
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1"><i class="bi bi-graph-up"></i> Reportes y Estadísticas</h2>
                <p class="text-muted mb-0">Análisis de ventas y rendimiento</p>
            </div>
        </div>

        <!-- Filtros de período -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4 col-lg-3">
                        <label class="form-label mb-1">Visualización:</label>
                        <select class="form-select" id="periodFilter">
                            <option value="diario">📊 Vista Diaria (30 días)</option>
                            <option value="semanal">📈 Vista Semanal (8 semanas)</option>
                            <option value="mensual" selected>💰 Vista Mensual (6 meses)</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 col-lg-2">
                        <button class="btn btn-primary w-100" onclick="actualizarGraficas()">
                            <i class="bi bi-arrow-clockwise"></i> Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficas de Ventas -->
        <div class="row g-3 g-md-4 mb-4">
            <!-- Gráfica Diaria -->
            <div class="col-12" id="chartDiarioContainer" style="display: none;">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-graph-up-arrow"></i> Ingresos Diarios (Últimos 30 días)</h5>
                        <span class="badge bg-light text-dark">Facturación por día</span>
                    </div>
                    <div class="card-body">
                        <canvas id="chartVentasDiario" height="60"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfica Semanal -->
            <div class="col-12" id="chartSemanalContainer" style="display: none;">
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-calendar-week"></i> Ingresos Semanales (Últimas 8 semanas)</h5>
                        <span class="badge bg-light text-dark">Facturación por semana</span>
                    </div>
                    <div class="card-body">
                        <canvas id="chartVentasSemanal" height="60"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfica Mensual -->
            <div class="col-12" id="chartMensualContainer">
                <div class="card">
                    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-calendar3"></i> Ingresos Mensuales (Últimos 6 meses)</h5>
                        <span class="badge bg-light text-dark">Facturación mes a mes</span>
                    </div>
                    <div class="card-body">
                        <canvas id="chartVentasMensual" height="60"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda fila: Métodos de Pago y Resumen -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Métodos de Pago</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartMetodosPago"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card h-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Resumen Financiero</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="text-primary mb-1" id="totalDiario">-</h4>
                                    <small class="text-muted">Total Diario Promedio</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="text-success mb-1" id="totalSemanal">-</h4>
                                    <small class="text-muted">Total Semanal Promedio</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="text-warning mb-1" id="totalMensual">-</h4>
                                    <small class="text-muted">Total Mensual Promedio</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="text-danger mb-1" id="totalGeneral">-</h4>
                                    <small class="text-muted">Total General</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking de Barberos y Servicios -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-trophy"></i> Ranking de Barberos (Este Mes)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartBarberos" height="100"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0"><i class="bi bi-star"></i> Servicios Más Vendidos</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartServicios" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de detalles -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-table"></i> Detalle de Barberos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Barbero</th>
                                <th>Servicios Realizados</th>
                                <th>Ingresos Generados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rankingBarberos as $barbero): ?>
                                <tr>
                                    <td><strong><?php echo $barbero['nombre'] . ' ' . $barbero['apellido']; ?></strong></td>
                                    <td><?php echo $barbero['total_servicios']; ?></td>
                                    <td class="text-success"><strong><?php echo number_format($barbero['ingresos_generados'], 2); ?> €</strong></td>
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
// Datos para las gráficas
const dataDiaria = <?php echo json_encode($estadisticasDiarias); ?>;
const dataSemanal = <?php echo json_encode($estadisticasSemanales); ?>;
const dataMensual = <?php echo json_encode($estadisticasMensuales); ?>;
const dataMetodosPago = <?php echo json_encode($metodosPago); ?>;
const dataRankingBarberos = <?php echo json_encode($rankingBarberos); ?>;
const dataServiciosMasVendidos = <?php echo json_encode($serviciosMasVendidos); ?>;

// Variables globales para las gráficas
let chartVentasDiario, chartVentasSemanal, chartVentasMensual, chartMetodosPago, chartBarberos, chartServicios;

$(document).ready(function() {
    inicializarGraficas();
    calcularResumenFinanciero();
});

function inicializarGraficas() {
    // ===========================================
    // GRÁFICA DIARIA - Line Chart profesional
    // ===========================================
    const ctxDiario = document.getElementById('chartVentasDiario').getContext('2d');
    chartVentasDiario = new Chart(ctxDiario, {
        type: 'line',
        data: {
            labels: dataDiaria.map(item => {
                const fecha = new Date(item.fecha);
                return fecha.toLocaleDateString('es-ES', { day: '2-digit', month: 'short' });
            }),
            datasets: [{
                label: 'Facturado',
                data: dataDiaria.map(item => parseFloat(item.ingresos)),
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(13, 110, 253, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(13, 110, 253, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(0) + ' €';
                        },
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Facturado: ' + context.parsed.y.toFixed(2) + ' €';
                        }
                    }
                }
            }
        }
    });

    // ===========================================
    // GRÁFICA SEMANAL - Bar Chart estilo trading
    // ===========================================
    const ctxSemanal = document.getElementById('chartVentasSemanal').getContext('2d');
    chartVentasSemanal = new Chart(ctxSemanal, {
        type: 'bar',
        data: {
            labels: dataSemanal.map(item => 'Sem ' + item.semana),
            datasets: [{
                label: 'Facturado',
                data: dataSemanal.map(item => parseFloat(item.ingresos)),
                backgroundColor: dataSemanal.map(item =>
                    parseFloat(item.ingresos) > 50 ? 'rgba(25, 135, 84, 0.8)' : 'rgba(13, 202, 240, 0.8)'
                ),
                borderColor: dataSemanal.map(item =>
                    parseFloat(item.ingresos) > 50 ? 'rgba(25, 135, 84, 1)' : 'rgba(13, 202, 240, 1)'
                ),
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(0) + ' €';
                        },
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Facturado: ' + context.parsed.y.toFixed(2) + ' €';
                        }
                    }
                }
            }
        }
    });

    // ===========================================
    // GRÁFICA MENSUAL - Line + Bar combo estilo financiero
    // ===========================================
    const ctxMensual = document.getElementById('chartVentasMensual').getContext('2d');
    chartVentasMensual = new Chart(ctxMensual, {
        type: 'bar',
        data: {
            labels: dataMensual.map(item => item.mes),
            datasets: [
                {
                    type: 'line',
                    label: 'Tendencia',
                    data: dataMensual.map(item => parseFloat(item.ingresos)),
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 0
                },
                {
                    type: 'bar',
                    label: 'Facturado',
                    data: dataMensual.map(item => parseFloat(item.ingresos)),
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(0) + ' €';
                        },
                        font: {
                            size: 13,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            if (context.dataset.type === 'bar') {
                                return 'Facturado: ' + context.parsed.y.toFixed(2) + ' €';
                            }
                            return null;
                        }
                    }
                }
            }
        }
    });

    // Gráfica de Métodos de Pago
    const ctxMetodos = document.getElementById('chartMetodosPago').getContext('2d');
    const colores = {
        'efectivo': '#198754',
        'tarjeta': '#0d6efd',
        'transferencia': '#0dcaf0',
        'otro': '#6c757d'
    };

    chartMetodosPago = new Chart(ctxMetodos, {
        type: 'doughnut',
        data: {
            labels: dataMetodosPago.map(item => item.metodo_pago.charAt(0).toUpperCase() + item.metodo_pago.slice(1)),
            datasets: [{
                data: dataMetodosPago.map(item => item.total),
                backgroundColor: dataMetodosPago.map(item => colores[item.metodo_pago]),
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfica de Ranking de Barberos
    const ctxBarberos = document.getElementById('chartBarberos').getContext('2d');
    chartBarberos = new Chart(ctxBarberos, {
        type: 'bar',
        data: {
            labels: dataRankingBarberos.map(item => item.nombre + ' ' + item.apellido),
            datasets: [{
                label: 'Servicios Realizados',
                data: dataRankingBarberos.map(item => item.total_servicios),
                backgroundColor: 'rgba(25, 135, 84, 0.7)',
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Gráfica de Servicios Más Vendidos
    const ctxServicios = document.getElementById('chartServicios').getContext('2d');
    chartServicios = new Chart(ctxServicios, {
        type: 'bar',
        data: {
            labels: dataServiciosMasVendidos.map(item => item.nombre),
            datasets: [{
                label: 'Veces Realizado',
                data: dataServiciosMasVendidos.map(item => item.total_vendido),
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

function actualizarGraficas() {
    const periodo = $('#periodFilter').val();

    // Ocultar todas las gráficas
    $('#chartDiarioContainer').hide();
    $('#chartSemanalContainer').hide();
    $('#chartMensualContainer').hide();

    // Mostrar la gráfica seleccionada
    switch(periodo) {
        case 'diario':
            $('#chartDiarioContainer').fadeIn();
            break;
        case 'semanal':
            $('#chartSemanalContainer').fadeIn();
            break;
        case 'mensual':
            $('#chartMensualContainer').fadeIn();
            break;
    }

    showSuccess('Vista actualizada a: ' + periodo);
}

function calcularResumenFinanciero() {
    // Calcular promedios
    let totalDiario = 0;
    if (dataDiaria.length > 0) {
        totalDiario = dataDiaria.reduce((sum, item) => sum + parseFloat(item.ingresos), 0) / dataDiaria.length;
    }

    let totalSemanal = 0;
    if (dataSemanal.length > 0) {
        totalSemanal = dataSemanal.reduce((sum, item) => sum + parseFloat(item.ingresos), 0) / dataSemanal.length;
    }

    let totalMensual = 0;
    if (dataMensual.length > 0) {
        totalMensual = dataMensual.reduce((sum, item) => sum + parseFloat(item.ingresos), 0) / dataMensual.length;
    }

    // Total general (suma de todos los meses)
    let totalGeneral = 0;
    if (dataMensual.length > 0) {
        totalGeneral = dataMensual.reduce((sum, item) => sum + parseFloat(item.ingresos), 0);
    }

    // Actualizar en la página
    $('#totalDiario').text(totalDiario.toFixed(2) + ' €');
    $('#totalSemanal').text(totalSemanal.toFixed(2) + ' €');
    $('#totalMensual').text(totalMensual.toFixed(2) + ' €');
    $('#totalGeneral').text(totalGeneral.toFixed(2) + ' €');
}
</script>
