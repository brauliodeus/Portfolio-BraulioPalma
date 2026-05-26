<?php
// dashboard.php
require_once 'includes/auth.php';

// Validar que el usuario esté logueado
requireLogin();

// Si el usuario presiona "Cerrar sesión"
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BraulioDev</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar p-3 d-flex flex-column">
            <div class="d-flex align-items-center mb-4 px-2">
                <h4 class="text-primary-custom fw-bold mb-0">Admin Panel</h4>
            </div>
            <div class="px-2 mb-4 text-secondary small">
                <i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
            </div>

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link py-2 px-3"
                        onclick="alert('Módulo de Biografía en construcción.'); return false;">
                        <i class="bi bi-person me-2"></i> Biografía
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link py-2 px-3"
                        onclick="alert('Módulo de Habilidades en construcción.'); return false;">
                        <i class="bi bi-wrench me-2"></i> Habilidades
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link py-2 px-3"
                        onclick="alert('Módulo de Tecnologías en construcción.'); return false;">
                        <i class="bi bi-code-slash me-2"></i> Tecnologías
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link py-2 px-3 active" id="tab-projects">
                        <i class="bi bi-folder me-2"></i> Proyectos
                    </a>
                </li>
            </ul>

            <hr class="text-secondary">

            <div class="mt-auto">
                <a href="?logout=true" class="nav-link py-2 px-3 text-danger">
                    <i class="bi bi-box-arrow-left me-2"></i> Cerrar Sesión
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-content p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">Dashboard</h2>
                <div class="d-flex align-items-center">
                    <span class="me-2 text-muted">Bienvenido,
                        <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Gestionar Proyectos</h5>
                    <button class="btn btn-primary btn-sm" onclick="openProjectModal()">
                        <i class="bi bi-plus-lg me-1"></i> Nuevo Proyecto
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Imagen</th>
                                    <th class="px-4 py-3">Título</th>
                                    <th class="px-4 py-3">Descripción Corta</th>
                                    <th class="px-4 py-3 text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="projectsTableBody">
                                <!-- Los proyectos se cargarán aquí vía AJAX -->
                                <tr>
                                    <td colspan="4" class="text-center py-4">Cargando proyectos...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para Crear/Editar Proyecto -->
    <div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModalTitle">Nuevo Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="projectForm">
                        <input type="hidden" id="projectId">
                        <div class="mb-3">
                            <label for="projectTitle" class="form-label">Título</label>
                            <input type="text" class="form-control" id="projectTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="projectImage" class="form-label">URL de la Imagen</label>
                            <input type="url" class="form-control" id="projectImage" required>
                        </div>
                        <div class="mb-3">
                            <label for="projectDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="projectDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="projectDemo" class="form-label">Link Demo (Opcional)</label>
                                <input type="url" class="form-control" id="projectDemo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="projectRepo" class="form-label">Link Repositorio (Opcional)</label>
                                <input type="url" class="form-control" id="projectRepo">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveProjectBtn" onclick="saveProject()">Guardar
                        Proyecto</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/admin.js"></script>
</body>

</html>