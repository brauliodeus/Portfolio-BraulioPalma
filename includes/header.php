<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BraulioDev - Portafolio</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>

<!-- Navbar Sticky -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">BraulioDev</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#biografia">Biografía</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#habilidades">Habilidades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tecnologias">Tecnologías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#proyectos">Proyectos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                        <a href="dashboard.php" class="btn btn-dark">Ir al Panel</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
