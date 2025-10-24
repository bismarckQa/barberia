<!-- Sidebar -->
<div class="bg-dark border-end" id="sidebar-wrapper" style="width: 250px; min-height: 100vh;">
    <div class="sidebar-heading text-white p-3 border-bottom border-secondary">
        <h4 class="mb-0"><i class="bi bi-scissors"></i> Barbería</h4>
        <small class="text-muted">Logroño, España</small>
    </div>
    <div class="list-group list-group-flush">
        <a href="?page=dashboard" class="list-group-item list-group-item-action bg-dark text-white border-secondary <?php echo (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : ''; ?>">
            <i class="bi bi-house-door"></i> Dashboard
        </a>

        <a href="?page=ventas/nueva" class="list-group-item list-group-item-action bg-dark text-white border-secondary bg-success bg-opacity-25 <?php echo (isset($_GET['page']) && $_GET['page'] == 'ventas/nueva') ? 'active' : ''; ?>">
            <i class="bi bi-cash-stack"></i> <strong>Nueva Venta</strong>
        </a>

        <a href="?page=ventas" class="list-group-item list-group-item-action bg-dark text-white border-secondary <?php echo (isset($_GET['page']) && $_GET['page'] == 'ventas') ? 'active' : ''; ?>">
            <i class="bi bi-receipt"></i> Ventas
        </a>

        <a href="?page=clientes" class="list-group-item list-group-item-action bg-dark text-white border-secondary <?php echo (isset($_GET['page']) && strpos($_GET['page'], 'clientes') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-people"></i> Clientes
        </a>

        <a href="?page=barberos" class="list-group-item list-group-item-action bg-dark text-white border-secondary <?php echo (isset($_GET['page']) && strpos($_GET['page'], 'barberos') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-person-badge"></i> Barberos
        </a>

        <a href="?page=servicios" class="list-group-item list-group-item-action bg-dark text-white border-secondary <?php echo (isset($_GET['page']) && strpos($_GET['page'], 'servicios') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-list-check"></i> Servicios
        </a>

        <a href="?page=citas" class="list-group-item list-group-item-action bg-dark text-white border-secondary <?php echo (isset($_GET['page']) && strpos($_GET['page'], 'citas') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-calendar-check"></i> Citas
        </a>

        <a href="?page=reportes" class="list-group-item list-group-item-action bg-dark text-white border-secondary <?php echo (isset($_GET['page']) && $_GET['page'] == 'reportes') ? 'active' : ''; ?>">
            <i class="bi bi-graph-up"></i> Reportes
        </a>
    </div>

    <div class="p-3 text-white-50 border-top border-secondary mt-auto" style="position: absolute; bottom: 0; width: 250px;">
        <small><i class="bi bi-clock"></i> <?php echo date('d/m/Y H:i'); ?></small>
    </div>
</div>
<!-- End Sidebar -->
