# Validaciones de Formularios - Clientes

## Resumen

Se han implementado validaciones en dos capas para los formularios de clientes (nuevo y editar):

1. **Frontend (JavaScript)** - Validación en tiempo real con `onblur`
2. **Backend (PHP)** - Validación en el servidor para mayor seguridad

---

## 1. Validaciones Frontend (JavaScript)

**Archivo**: `assets/js/validaciones-clientes.js`

### Campos Validados:

#### **Nombre** (obligatorio)
- ✅ Solo letras, espacios, acentos y ñ
- ✅ Mínimo 2 caracteres
- ❌ No se permiten números ni caracteres especiales
- **Evento**: `onblur` (al salir del campo)
- **Feedback**: SweetAlert2 toast + clase `is-invalid/is-valid`

#### **Apellido** (obligatorio)
- ✅ Solo letras, espacios, acentos y ñ
- ✅ Mínimo 2 caracteres
- ❌ No se permiten números ni caracteres especiales
- **Evento**: `onblur` (al salir del campo)
- **Feedback**: SweetAlert2 toast + clase `is-invalid/is-valid`

#### **Teléfono** (opcional)
- ✅ Solo números
- ✅ Entre 9 y 11 dígitos
- ❌ No se permiten letras ni caracteres especiales
- **Evento**: `onblur` (al salir del campo)
- **Feedback**: SweetAlert2 toast + clase `is-invalid/is-valid`

#### **Edad** (opcional)
- ✅ Solo números
- ✅ Rango: 1 a 120 años
- ❌ No se permiten letras ni decimales
- **Evento**: `onblur` (al salir del campo)
- **Feedback**: SweetAlert2 toast + clase `is-invalid/is-valid`

### Funciones Principales:

```javascript
// Inicializar validaciones automáticamente
inicializarValidacionesCliente();

// Validar todo el formulario antes de enviar
validarFormularioCliente('formCliente');

// Validaciones individuales
validarNombre(inputElement);
validarTelefono(inputElement);
validarEdad(inputElement);
```

### Comportamiento:

1. **Validación en tiempo real**: Al salir de cada campo (`onblur`), se valida inmediatamente
2. **Feedback visual**: Bordes verdes (✓) o rojos (✗) según validación
3. **Toasts de SweetAlert2**: Mensajes emergentes con el error específico
4. **Validación al escribir**: Si hay error, se valida mientras escribe para limpiar el estado
5. **Validación final**: Antes de enviar, se validan todos los campos nuevamente

---

## 2. Validaciones Backend (PHP)

**Archivo**: `controllers/ClienteController.php`

### Método de Validación:

```php
private function validarDatosCliente($data, $esNuevo = true)
```

### Reglas Aplicadas:

#### **Nombre** (obligatorio)
```php
- Campo no vacío
- Mínimo 2 caracteres
- Regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u (solo letras, acentos, ñ)
```

#### **Apellido** (obligatorio)
```php
- Campo no vacío
- Mínimo 2 caracteres
- Regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u (solo letras, acentos, ñ)
```

#### **Teléfono** (opcional)
```php
- Regex: /^[0-9]+$/ (solo números)
- Longitud: 9 a 11 dígitos
```

#### **Edad** (opcional)
```php
- is_numeric() = true
- Rango: 1 a 120
- Conversión a int con intval()
```

### Respuestas de Error:

Si hay errores de validación, se retorna:

```json
{
    "error": "El nombre es obligatorio. El apellido solo puede contener letras"
}
```

---

## 3. Integración en Formularios

### Formulario Nuevo Cliente
**Archivo**: `views/clientes/nuevo.php`

```javascript
// Se carga el archivo de validaciones
<script src="assets/js/validaciones-clientes.js"></script>

// En el submit, se valida antes de enviar
if (!validarFormularioCliente('formCliente')) {
    return; // Detiene el envío si hay errores
}
```

### Formulario Editar Cliente
**Archivo**: `views/clientes/editar.php`

```javascript
// Misma implementación que nuevo cliente
<script src="assets/js/validaciones-clientes.js"></script>

if (!validarFormularioCliente('formCliente')) {
    return;
}
```

---

## 4. Ejemplos de Validación

### ✅ **Válidos**:

```
Nombre: Juan Carlos
Apellido: García Pérez
Teléfono: 612345678
Edad: 35
```

```
Nombre: María José
Apellido: Sánchez López
Teléfono: 34912345678 (11 dígitos)
Edad: 25
```

### ❌ **Inválidos**:

```
Nombre: Juan123          → Error: "El nombre solo puede contener letras"
Apellido: García-López   → Error: "El apellido solo puede contener letras"
Teléfono: 61234567A      → Error: "El teléfono solo puede contener números"
Teléfono: 123            → Error: "El teléfono debe tener al menos 9 dígitos"
Teléfono: 123456789012   → Error: "El teléfono no puede tener más de 11 dígitos"
Edad: 150                → Error: "La edad debe estar entre 1 y 120 años"
Edad: abc                → Error: "La edad solo puede contener números"
```

---

## 5. Flujo de Validación Completo

```
Usuario escribe en el campo
        ↓
Sale del campo (blur)
        ↓
Se ejecuta validación JavaScript
        ↓
¿Es válido?
├─ Sí → Borde verde (is-valid)
└─ No → Borde rojo (is-invalid) + Toast con error
        ↓
Usuario hace clic en "Guardar"
        ↓
Se valida todo el formulario (JavaScript)
        ↓
¿Todo válido?
├─ No → Se muestra SweetAlert con campos erróneos
└─ Sí → Se envía al servidor
        ↓
Backend valida los datos (PHP)
        ↓
¿Todo válido?
├─ No → Retorna JSON con error
└─ Sí → Guarda en base de datos
        ↓
Retorna JSON de éxito
        ↓
Muestra Toast de éxito y redirige
```

---

## 6. Ventajas del Sistema

✅ **Doble capa de seguridad**: Frontend + Backend
✅ **Feedback inmediato**: Usuario sabe al instante si algo está mal
✅ **Sin conflictos con CRUD**: Las validaciones se ejecutan ANTES del envío
✅ **Mensajes claros**: SweetAlert2 con mensajes específicos
✅ **Experiencia fluida**: Validación con `onblur` no es invasiva
✅ **Trim automático**: Se eliminan espacios antes/después
✅ **Regex consistentes**: Mismas reglas en JS y PHP

---

## 7. Mantenimiento

### Para agregar nuevas validaciones:

1. **JavaScript**: Agregar función en `validaciones-clientes.js`
2. **PHP**: Agregar regla en `validarDatosCliente()` del controller
3. **HTML**: Agregar evento `onblur` si es necesario (ya auto-inicializado)

### Para modificar mensajes de error:

- **Frontend**: Editar strings en `validaciones-clientes.js`
- **Backend**: Editar strings en `ClienteController.php`

---

## 8. Testing

### Pruebas recomendadas:

1. ✅ Intentar guardar con nombre vacío
2. ✅ Intentar guardar con nombre "Juan123"
3. ✅ Intentar guardar con teléfono "abc"
4. ✅ Intentar guardar con teléfono de 5 dígitos
5. ✅ Intentar guardar con edad 150
6. ✅ Editar un cliente existente con datos inválidos
7. ✅ Verificar que datos válidos sí se guarden correctamente

---

**Fecha de implementación**: 24/10/2025
**Desarrollado con**: SweetAlert2, JavaScript Vanilla, PHP PDO
