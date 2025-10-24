/**
 * JavaScript principal - Sistema Barbería
 * Funciones globales, AJAX, validaciones
 */

// Configuración global de SweetAlert
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Función para mostrar alertas de éxito
function showSuccess(message) {
    Toast.fire({
        icon: 'success',
        title: message
    });
}

// Función para mostrar alertas de error
function showError(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}

// Función para mostrar alertas de advertencia
function showWarning(message) {
    Toast.fire({
        icon: 'warning',
        title: message
    });
}

// Función para mostrar alertas de info
function showInfo(message) {
    Toast.fire({
        icon: 'info',
        title: message
    });
}

// Confirmar eliminación
function confirmarEliminacion(callback) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

// Inicializar DataTables en español
function initDataTable(selector, options = {}) {
    const defaultOptions = {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        pageLength: 25,
        responsive: true,
        order: [[0, 'desc']]
    };

    return $(selector).DataTable({...defaultOptions, ...options});
}

// Formatear números como moneda (euros)
function formatEuro(amount) {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'EUR'
    }).format(amount);
}

// Formatear fecha
function formatFecha(fecha) {
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

// Formatear fecha y hora
function formatFechaHora(fecha) {
    const date = new Date(fecha);
    return date.toLocaleString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Loading overlay
function showLoading() {
    Swal.fire({
        title: 'Cargando...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

function hideLoading() {
    Swal.close();
}

// AJAX Helper
function ajaxRequest(url, method, data, successCallback, errorCallback) {
    showLoading();

    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: 'json',
        success: function(response) {
            hideLoading();
            if (response.success) {
                if (successCallback) successCallback(response);
            } else if (response.error) {
                showError(response.error);
                if (errorCallback) errorCallback(response);
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            showError('Error en la solicitud: ' + error);
            if (errorCallback) errorCallback(error);
        }
    });
}

// Validar formularios
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        showWarning('Por favor, completa todos los campos obligatorios');
        return false;
    }
    return true;
}

// Limpiar formulario
function clearForm(formId) {
    const form = document.getElementById(formId);
    form.reset();
    form.classList.remove('was-validated');
}

// Auto-actualizar reloj en sidebar
function updateClock() {
    const now = new Date();
    const time = now.toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
    });
    const date = now.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });

    const clockElement = document.querySelector('.sidebar-heading small');
    if (clockElement) {
        clockElement.innerHTML = `<i class="bi bi-clock"></i> ${date} ${time}`;
    }
}

// Inicializar cuando el DOM esté listo
$(document).ready(function() {
    // Actualizar reloj cada minuto
    updateClock();
    setInterval(updateClock, 60000);

    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Animación fade-in para contenido
    $('.content-wrapper').addClass('fade-in');
});

// Búsqueda en tiempo real
function setupLiveSearch(inputId, callback) {
    let timeout = null;
    $(`#${inputId}`).on('keyup', function() {
        clearTimeout(timeout);
        const query = $(this).val();

        if (query.length >= 2) {
            timeout = setTimeout(() => {
                callback(query);
            }, 500);
        }
    });
}
