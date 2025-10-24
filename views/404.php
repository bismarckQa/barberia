<?php
$pageTitle = 'Página no encontrada - Sistema Barbería';
include 'includes/header.php';
?>

<div class="error-page">
    <div class="container text-center">
        <h1 style="font-size: 8rem; font-weight: bold; color: #dee2e6;">404</h1>
        <h2 class="mb-4">Página no encontrada</h2>
        <p class="text-muted mb-4">La página que buscas no existe</p>
        <a href="?page=dashboard" class="btn btn-primary">
            <i class="bi bi-house-door"></i> Volver al Dashboard
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
