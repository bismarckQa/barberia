/**
 * Validaciones para formularios de Clientes
 * Usa onblur para validar en tiempo real
 */

// Expresiones regulares para validaciones
const regexPatterns = {
    // Solo letras, espacios, acentos, ñ
    soloLetras: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
    // Solo números
    soloNumeros: /^[0-9]+$/,
    // Teléfono: solo números, máximo 11 dígitos
    telefono: /^[0-9]{1,11}$/
};

/**
 * Validar campo Nombre
 */
function validarNombre(input) {
    const valor = input.value.trim();
    const campo = input.id;
    const label = campo === 'nombre' ? 'Nombre' : 'Apellido';

    // Resetear estado visual
    input.classList.remove('is-invalid', 'is-valid');

    // Campo vacío
    if (valor === '') {
        if (input.hasAttribute('required')) {
            input.classList.add('is-invalid');
            mostrarErrorCampo(input, `El campo ${label} es obligatorio`);
            return false;
        }
        return true;
    }

    // Verificar longitud mínima
    if (valor.length < 2) {
        input.classList.add('is-invalid');
        mostrarErrorCampo(input, `${label} debe tener al menos 2 caracteres`);
        return false;
    }

    // Verificar que solo contenga letras
    if (!regexPatterns.soloLetras.test(valor)) {
        input.classList.add('is-invalid');
        mostrarErrorCampo(input, `${label} solo puede contener letras`);
        return false;
    }

    // Validación exitosa
    input.classList.add('is-valid');
    return true;
}

/**
 * Validar campo Teléfono
 */
function validarTelefono(input) {
    const valor = input.value.trim();

    // Resetear estado visual
    input.classList.remove('is-invalid', 'is-valid');

    // Campo vacío (es opcional)
    if (valor === '') {
        return true;
    }

    // Verificar que solo contenga números
    if (!regexPatterns.soloNumeros.test(valor)) {
        input.classList.add('is-invalid');
        mostrarErrorCampo(input, 'El teléfono solo puede contener números');
        return false;
    }

    // Verificar longitud máxima
    if (valor.length > 11) {
        input.classList.add('is-invalid');
        mostrarErrorCampo(input, 'El teléfono no puede tener más de 11 dígitos');
        return false;
    }

    // Verificar longitud mínima
    if (valor.length < 9) {
        input.classList.add('is-invalid');
        mostrarErrorCampo(input, 'El teléfono debe tener al menos 9 dígitos');
        return false;
    }

    // Validación exitosa
    input.classList.add('is-valid');
    return true;
}

/**
 * Validar campo Edad
 */
function validarEdad(input) {
    const valor = input.value.trim();

    // Resetear estado visual
    input.classList.remove('is-invalid', 'is-valid');

    // Campo vacío (es opcional)
    if (valor === '') {
        return true;
    }

    // Verificar que solo contenga números
    if (!regexPatterns.soloNumeros.test(valor)) {
        input.classList.add('is-invalid');
        mostrarErrorCampo(input, 'La edad solo puede contener números');
        return false;
    }

    const edad = parseInt(valor);

    // Verificar rango
    if (edad < 1 || edad > 120) {
        input.classList.add('is-invalid');
        mostrarErrorCampo(input, 'La edad debe estar entre 1 y 120 años');
        return false;
    }

    // Validación exitosa
    input.classList.add('is-valid');
    return true;
}

/**
 * Mostrar error con SweetAlert2 (Toast pequeño junto al campo)
 */
function mostrarErrorCampo(input, mensaje) {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: mensaje,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

/**
 * Validar formulario completo antes de enviar
 */
function validarFormularioCliente(formId) {
    const form = document.getElementById(formId);
    let esValido = true;
    let errores = [];

    // Validar nombre
    const inputNombre = form.querySelector('#nombre');
    if (inputNombre && !validarNombre(inputNombre)) {
        esValido = false;
        errores.push('Nombre');
    }

    // Validar apellido
    const inputApellido = form.querySelector('#apellido');
    if (inputApellido && !validarNombre(inputApellido)) {
        esValido = false;
        errores.push('Apellido');
    }

    // Validar teléfono
    const inputTelefono = form.querySelector('#telefono');
    if (inputTelefono && !validarTelefono(inputTelefono)) {
        esValido = false;
        errores.push('Teléfono');
    }

    // Validar edad
    const inputEdad = form.querySelector('#edad');
    if (inputEdad && !validarEdad(inputEdad)) {
        esValido = false;
        errores.push('Edad');
    }

    // Mostrar resumen de errores si hay
    if (!esValido) {
        Swal.fire({
            icon: 'error',
            title: 'Errores en el formulario',
            html: `Por favor, corrige los siguientes campos:<br><strong>${errores.join(', ')}</strong>`,
            confirmButtonText: 'Entendido'
        });
    }

    return esValido;
}

/**
 * Inicializar validaciones en formulario de cliente
 */
function inicializarValidacionesCliente() {
    // Validar nombre en onblur
    const inputNombre = document.getElementById('nombre');
    if (inputNombre) {
        inputNombre.addEventListener('blur', function() {
            validarNombre(this);
        });

        // También validar mientras escribe (opcional, más suave)
        inputNombre.addEventListener('input', function() {
            // Solo limpiar error si está escribiendo correctamente
            if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                validarNombre(this);
            }
        });
    }

    // Validar apellido en onblur
    const inputApellido = document.getElementById('apellido');
    if (inputApellido) {
        inputApellido.addEventListener('blur', function() {
            validarNombre(this);
        });

        inputApellido.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                validarNombre(this);
            }
        });
    }

    // Validar teléfono en onblur
    const inputTelefono = document.getElementById('telefono');
    if (inputTelefono) {
        inputTelefono.addEventListener('blur', function() {
            validarTelefono(this);
        });

        inputTelefono.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                validarTelefono(this);
            }
        });
    }

    // Validar edad en onblur
    const inputEdad = document.getElementById('edad');
    if (inputEdad) {
        inputEdad.addEventListener('blur', function() {
            validarEdad(this);
        });

        inputEdad.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                validarEdad(this);
            }
        });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    inicializarValidacionesCliente();
});
