# 🚀 Guía Rápida de Instalación

## ⚡ Instalación en 3 pasos (5 minutos)

### Paso 1: Iniciar XAMPP
1. Abrir **XAMPP Control Panel**
2. Click en **Start** en Apache
3. Click en **Start** en MySQL
4. Esperar a que ambos estén en verde

### Paso 2: Crear la base de datos
1. Abrir navegador
2. Ir a: `http://localhost/phpmyadmin`
3. Click en pestaña **"Importar"**
4. Click en **"Seleccionar archivo"**
5. Buscar y seleccionar: `C:\xampp\htdocs\barberia\sql\install.sql`
6. Click en **"Continuar"** al final de la página
7. Esperar mensaje: **"Importación finalizada correctamente"**

### Paso 3: Verificar instalación
1. Abrir: `http://localhost/barberia/test_conexion`
2. Verificar que todo esté en ✓ verde
3. Click en el enlace para ir al sistema

---

## ✅ Checklist de verificación

Antes de usar el sistema, verificar que:

- [ ] Apache está corriendo (luz verde en XAMPP)
- [ ] MySQL está corriendo (luz verde en XAMPP)
- [ ] Base de datos `barberia_db` existe en phpMyAdmin
- [ ] La página `test_conexion` muestra todo en verde
- [ ] El dashboard carga correctamente

---

## 🎯 Primer uso

### 1. Registrar barberos
- Ir a: **Barberos** → **Nuevo Barbero**
- Agregar al menos 1 barbero
- Ejemplo:
  - Nombre: Juan
  - Apellido: Pérez
  - Teléfono: 611222333
  - Fecha ingreso: (hoy)

### 2. Verificar servicios
- Ir a: **Servicios**
- Ya vienen 8 servicios precargados
- Puedes editarlos o agregar más

### 3. Registrar primera venta
- Click en el botón verde **"Nueva Venta"**
- Seleccionar barbero
- Seleccionar servicio (el precio se autocompleta)
- Click en **"Registrar Venta"**

### 4. Ver estadísticas
- Ir a: **Reportes**
- Ver las gráficas generadas automáticamente

---

## 🔧 Configuración (Opcional)

### Cambiar nombre de la barbería
Editar archivo: `includes/sidebar.php`

Buscar línea 4:
```html
<h4 class="mb-0"><i class="bi bi-scissors"></i> Barbería</h4>
```

Cambiar "Barbería" por el nombre de tu negocio.

### Cambiar usuario/contraseña de MySQL
Editar archivo: `config/database.php`

Cambiar líneas 11-12:
```php
private $username = 'root';        // Tu usuario MySQL
private $password = '';            // Tu contraseña MySQL
```

---

## ❌ Problemas comunes

### "No se puede conectar a la base de datos"
**Solución:**
1. Verificar que MySQL esté corriendo en XAMPP
2. Importar `sql/install.sql` en phpMyAdmin
3. Verificar credenciales en `config/database.php`

### "Error 404 - Página no encontrada"
**Solución:**
1. Verificar que la carpeta esté en `C:\xampp\htdocs\barberia`
2. Acceder a: `http://localhost/barberia` (no olvidar `/barberia`)

### "Las gráficas no se muestran"
**Solución:**
1. Registrar al menos 1 venta
2. Verificar conexión a internet (Chart.js usa CDN)
3. Refrescar la página (F5)

### "SweetAlert no funciona"
**Solución:**
1. Verificar conexión a internet
2. Abrir consola del navegador (F12) y revisar errores

---

## 📞 Necesitas ayuda?

1. ✅ Revisar este documento
2. ✅ Revisar `README.md` (documentación completa)
3. ✅ Ejecutar `test_conexion.php` para diagnóstico
4. ✅ Revisar logs de Apache: `C:\xampp\apache\logs\error.log`

---

## 🎉 ¡Listo!

Si todo está en verde en `test_conexion.php`, el sistema está listo para usar.

**Acceder al sistema:**
```
http://localhost/barberia
```

---

**Nota**: Este sistema está diseñado para uso local en XAMPP. No requiere login porque está pensado para usarse en el mostrador de la barbería.
