# 💈 Sistema de Gestión para Barbería

Sistema web completo para gestionar una barbería/peluquería de barrio. Desarrollado con **PHP MVC**, **MySQL**, **Bootstrap 5**, **Chart.js** y **SweetAlert2**.

**Ubicación**: Logroño, España
**Moneda**: Euro (€)

---

## 📋 Requisitos

- **XAMPP** (Apache + PHP 7.4+ + MySQL 5.7+)
- Navegador web moderno (Chrome, Firefox, Edge)

---

## 🚀 Instalación

### 1. Preparar el entorno

1. Instalar **XAMPP**
2. Copiar la carpeta `barberia` en `C:\xampp\htdocs\`
3. Iniciar Apache y MySQL desde el panel de control de XAMPP

### 2. Crear la base de datos

1. Abrir **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Ir a la pestaña **Importar**
3. Seleccionar el archivo: `sql/install.sql`
4. Hacer clic en **Continuar**

Esto creará:
- Base de datos: `barberia_db`
- 5 tablas principales
- 8 servicios precargados

### 3. Configurar la conexión (opcional)

Si usas otro usuario/contraseña de MySQL, editar:
```
config/database.php
```

Cambiar las siguientes líneas:
```php
private $username = 'root';      // Tu usuario
private $password = '';          // Tu contraseña
```

### 4. Acceder al sistema

Abrir el navegador y visitar:
```
http://localhost/barberia
```

¡Listo! El sistema abrirá directamente en el **Dashboard**.

---

## 📦 Estructura del Proyecto

```
barberia/
├── config/
│   └── database.php          # Conexión PDO a MySQL
├── models/                   # Modelos (POO)
│   ├── Database.php          # Clase base
│   ├── Cliente.php
│   ├── Barbero.php
│   ├── Servicio.php
│   ├── Cita.php
│   └── Venta.php
├── controllers/              # Controladores (lógica de negocio)
│   ├── ClienteController.php
│   ├── BarberoController.php
│   ├── ServicioController.php
│   ├── CitaController.php
│   ├── VentaController.php
│   └── DashboardController.php
├── views/                    # Vistas (HTML + PHP)
│   ├── dashboard.php
│   ├── clientes/
│   ├── barberos/
│   ├── servicios/
│   ├── citas/
│   ├── ventas/
│   └── reportes/
├── api/                      # Endpoints AJAX
│   ├── clientes.php
│   ├── barberos.php
│   ├── servicios.php
│   ├── citas.php
│   └── ventas.php
├── assets/
│   ├── css/styles.css
│   └── js/main.js
├── includes/                 # Plantillas reutilizables
│   ├── header.php
│   ├── sidebar.php
│   └── footer.php
├── sql/                      # Scripts de base de datos
│   ├── install.sql           # Instalación completa
│   ├── clientes.sql
│   ├── barberos.sql
│   ├── servicios.sql
│   ├── citas.sql
│   └── ventas.sql
├── .htaccess                 # URLs limpias (sin .php)
├── index.php                 # Router principal
└── README.md
```

---

## 🎯 Módulos del Sistema

### 1. 🏠 Dashboard
- Vista general del negocio
- Ventas del día con total en euros
- Clientes atendidos hoy
- Próximas citas
- Accesos rápidos a funciones principales

### 2. 💰 Ventas (CORE)
- **Nueva Venta**: Formulario rápido (< 30 segundos)
  - Selección de barbero y servicio
  - Cliente opcional (búsqueda rápida)
  - Precio editable (se autocompleta)
  - Métodos de pago: Efectivo, Tarjeta, Transferencia
- **Listado**: Historial completo con DataTables

### 3. 👥 Clientes
- CRUD completo (Crear, Leer, Actualizar, Eliminar)
- Búsqueda por nombre o teléfono
- Ficha individual con:
  - Total de visitas
  - Total gastado
  - Última visita
  - Historial completo de servicios
- Estados: Activo / Inactivo

### 4. ✂️ Barberos
- CRUD completo
- **Protección**: No se pueden eliminar si tienen ventas (solo desactivar)
- Estadísticas por barbero:
  - Servicios hoy / semana / mes
  - Total de servicios
  - Servicios más realizados
- Estados: Activo / Inactivo

### 5. 📋 Servicios
- CRUD completo
- Vista de tarjetas (grid)
- **Protección**: No se pueden eliminar si tienen ventas
- Servicios predeterminados:
  - Corte Adulto (15€)
  - Corte Niño (10€)
  - Barba (8€)
  - Corte + Barba (20€)
  - Tinte (25€)
  - Alisado (35€)
  - Afeitado (10€)
  - Diseño (5€)

### 6. 📅 Citas
- CRUD completo
- Agenda diaria
- Sin vinculación a cliente registrado (solo nombre y teléfono)
- Estados: Esperando, Atendido, No vino, Cancelada
- Cambio rápido de estado con botones

### 7. 📊 Reportes y Estadísticas
Gráficas interactivas con **Chart.js**:
1. **Ingresos por período** (Bar chart)
   - Últimos 7 días
   - Últimas 4 semanas
   - Últimos 6 meses
2. **Métodos de pago** (Doughnut chart)
3. **Ranking de barberos** (Horizontal bar)
4. **Servicios más vendidos** (Bar chart)
5. **Tabla detallada** de productividad

---

## 🔧 Tecnologías Utilizadas

### Backend
- **PHP 7.4+** (Vanilla, sin frameworks)
- **MySQL 5.7+**
- **PDO** (PHP Data Objects)
- Patrón **MVC** (Model-View-Controller)
- **POO** (Programación Orientada a Objetos)

### Frontend
- **Bootstrap 5.3.2** (Framework CSS)
- **Bootstrap Icons** (Iconografía)
- **JavaScript Vanilla** + **jQuery 3.7.1**
- **SweetAlert2** (Notificaciones elegantes)
- **DataTables** (Tablas interactivas)
- **Chart.js 4.4.1** (Gráficas)

### Características
- URLs limpias (sin .php) gracias a `.htaccess`
- AJAX para todas las operaciones (sin recargar página)
- Validaciones client-side y server-side
- Responsive (funciona en móvil y tablet)
- Interfaz moderna y limpia

---

## 📖 Uso del Sistema

### Flujo de trabajo típico:

1. **Registrar barberos y servicios** (configuración inicial)
2. **Agendar citas** (cuando llaman por teléfono)
3. **Registrar venta** cuando el cliente llega:
   - Seleccionar barbero
   - Seleccionar servicio
   - Buscar cliente (opcional)
   - Confirmar precio
   - Registrar (< 30 seg)
4. **Ver reportes** al final del día/semana/mes

### Atajos rápidos:
- **Nueva Venta**: Botón verde en sidebar y dashboard
- **Búsqueda de clientes**: Modal con búsqueda en tiempo real
- **Cambio de estado**: Botones directos en tablas
- **Estadísticas**: Se calculan automáticamente

---

## ⚙️ Configuración Avanzada

### Cambiar nombre del negocio
Editar: `includes/sidebar.php` línea 4

### Agregar más servicios
1. Ir a: `?page=servicios/nuevo`
2. Completar formulario
3. Guardar

### Backup de la base de datos
```sql
-- Desde phpMyAdmin:
1. Seleccionar barberia_db
2. Pestaña "Exportar"
3. Método rápido > SQL
4. Continuar
```

---

## 🔒 Seguridad

### Validaciones implementadas:
- ✅ Validación de formularios (HTML5 + JavaScript)
- ✅ Prepared statements (PDO) contra SQL Injection
- ✅ Validación de tipos de datos en controllers
- ✅ Protección de eliminación (barberos y servicios con ventas)
- ✅ Headers de Content-Type en APIs

### Recomendaciones:
- Cambiar las credenciales de MySQL por defecto
- No usar en producción sin HTTPS
- Implementar backup automático
- Restringir acceso a carpetas `/api/` y `/config/`

---

## 🐛 Solución de Problemas

### Error: "Base de datos no encontrada"
- Verificar que se importó `sql/install.sql`
- Verificar credenciales en `config/database.php`

### Error: "404 - Página no encontrada"
- Verificar que Apache tiene `mod_rewrite` activado
- Verificar que `.htaccess` existe en la raíz

### Las gráficas no se muestran
- Verificar que hay datos en la tabla `ventas`
- Abrir consola del navegador (F12) para ver errores JavaScript

### SweetAlert no funciona
- Verificar conexión a internet (usa CDN)
- O descargar las librerías localmente

---

## 📝 Notas Importantes

1. **No tiene login**: El sistema abre directamente en el dashboard
   - Diseñado para uso local en la caja del negocio
   - Si se requiere login, se debe implementar aparte

2. **Cliente opcional en ventas**: Muchas ventas se registran sin cliente
   - Útil para clientes esporádicos
   - Solo se vincula si el cliente está registrado

3. **Barberos no se eliminan**: Solo se desactivan
   - Protege la integridad del historial de ventas
   - Mismo comportamiento con servicios

4. **Moneda fija en euros**:
   - Formato: `1.234,56 €`
   - Sin conversión de moneda

---

## 🎁 Características Especiales

### Formulario de venta optimizado:
- Autocompletar precio al seleccionar servicio
- Búsqueda de cliente en modal
- Resumen en tiempo real
- Validación instantánea

### Dashboard inteligente:
- Estadísticas en tiempo real
- Carga rápida (solo queries necesarias)
- Actualización automática del reloj

### Reportes flexibles:
- Cambiar período con un clic
- Gráficas actualizables sin recargar
- Exportable a PDF (función futura)

---

## 👨‍💻 Créditos

**Desarrollado para**: Barbería de barrio - Logroño, España
**Tecnologías**: PHP MVC + MySQL + Bootstrap 5 + Chart.js
**Patrón**: MVC (Model-View-Controller)
**Año**: 2025

---

## 📞 Soporte

Para dudas o problemas:
1. Revisar esta documentación
2. Verificar logs de Apache: `C:\xampp\apache\logs\error.log`
3. Verificar logs de MySQL: `C:\xampp\mysql\data\`

---

## 🚀 Próximas Mejoras (Roadmap)

- [ ] Sistema de backup automático
- [ ] Exportar reportes a PDF
- [ ] Envío de recordatorios por WhatsApp
- [ ] Sistema de comisiones por barbero
- [ ] Múltiples sucursales
- [ ] Control de inventario de productos
- [ ] Modo oscuro

---

**¡Disfruta del sistema! 💈✂️**
