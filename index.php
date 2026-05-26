<?php
// index.php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Obtener proyectos de la base de datos
try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    $projects = [];
}

include 'includes/header.php';
?>

<!-- HERO / BIOGRAFÍA -->
<section id="biografia" class="section-padding bg-light">
    <div class="container text-center">
        <img src="assets/images/Senku.png" alt="Braulio" class="hero-profile-img rounded-circle mb-4">
        <h1 class="display-4 fw-bold mb-2">Hola, soy <span class="text-primary-custom">Braulio</span></h1>
        <h2 class="h3 text-muted mb-4">Desarrollador Web Full Stack</h2>
        <p class="lead max-w-7xl mx-auto mb-5" style="max-width: 800px; margin: 0 auto;">
            Especializado en la creación de experiencias digitales sólidas y escalables. Combino mis conocimientos en diseño de interfaces y desarrollo backend para construir aplicaciones completas, eficientes y centradas en el usuario.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#contacto" class="btn btn-primary btn-lg px-4">Contactarme</a>
            <a href="#proyectos" class="btn btn-outline-secondary btn-lg px-4 bg-white text-dark">Ver Proyectos</a>
        </div>
    </div>
</section>

<!-- HABILIDADES Y HERRAMIENTAS -->
<section id="habilidades" class="section-padding bg-gray-50">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Habilidades y Herramientas</h2>
        <div class="row g-4">
            <!-- Habilidad 1 -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skill-card card h-100 text-center p-4 bg-white rounded-3">
                    <i class="bi bi-filetype-html skill-icon text-warning"></i>
                    <h3 class="h5 mb-0">HTML5</h3>
                </div>
            </div>
            <!-- Habilidad 2 -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skill-card card h-100 text-center p-4 bg-white rounded-3">
                    <i class="bi bi-filetype-css skill-icon text-primary"></i>
                    <h3 class="h5 mb-0">CSS3</h3>
                </div>
            </div>
            <!-- Habilidad 3 -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skill-card card h-100 text-center p-4 bg-white rounded-3">
                    <i class="bi bi-filetype-js skill-icon text-warning"></i>
                    <h3 class="h5 mb-0">JavaScript</h3>
                </div>
            </div>
            <!-- Habilidad 4 -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skill-card card h-100 text-center p-4 bg-white rounded-3">
                    <i class="bi bi-filetype-php skill-icon" style="color: #4F5D95;"></i>
                    <h3 class="h5 mb-0">PHP</h3>
                </div>
            </div>
            <!-- Habilidad 5 -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skill-card card h-100 text-center p-4 bg-white rounded-3">
                    <i class="bi bi-database skill-icon text-info"></i>
                    <h3 class="h5 mb-0">MySQL</h3>
                </div>
            </div>
            <!-- Habilidad 6 -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skill-card card h-100 text-center p-4 bg-white rounded-3">
                    <i class="bi bi-bootstrap skill-icon" style="color: #7952b3;"></i>
                    <h3 class="h5 mb-0">Bootstrap</h3>
                </div>
            </div>
            <!-- Habilidad 7 -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skill-card card h-100 text-center p-4 bg-white rounded-3">
                    <i class="bi bi-github skill-icon text-dark"></i>
                    <h3 class="h5 mb-0">GitHub</h3>
                </div>
            </div>
            <!-- Habilidad 8 -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skill-card card h-100 text-center p-4 bg-white rounded-3">
                    <i class="bi bi-cpu skill-icon text-success"></i>
                    <h3 class="h5 mb-0">IA Aplicada</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NIVEL DE TECNOLOGÍAS -->
<section id="tecnologias" class="section-padding bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Nivel de Tecnologías</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold">Frontend (HTML, CSS, JS)</span>
                        <span class="text-muted">90%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold">Backend (PHP)</span>
                        <span class="text-muted">85%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold">Base de Datos (MySQL)</span>
                        <span class="text-muted">80%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold">Frameworks CSS (Bootstrap)</span>
                        <span class="text-muted">95%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold">Diseño UX/UI</span>
                        <span class="text-muted">75%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- PROYECTOS REALIZADOS -->
<section id="proyectos" class="section-padding bg-gray-50">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Proyectos Realizados</h2>
        <div class="row g-4">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="project-card card bg-white rounded-3 overflow-hidden border-0">
                            <img src="<?php echo htmlspecialchars($project->image_url); ?>" alt="<?php echo htmlspecialchars($project->title); ?>" class="project-img w-100">
                            <div class="card-body d-flex flex-column p-4">
                                <h3 class="h5 fw-bold mb-3"><?php echo htmlspecialchars($project->title); ?></h3>
                                <p class="text-muted flex-grow-1"><?php echo htmlspecialchars($project->description); ?></p>
                                <div class="d-flex gap-2 mt-4">
                                    <?php if (!empty($project->demo_link)): ?>
                                        <a href="<?php echo htmlspecialchars($project->demo_link); ?>" target="_blank" rel="noreferrer" class="btn btn-primary flex-grow-1">
                                            <i class="bi bi-box-arrow-up-right me-1"></i> Demo
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($project->repo_link)): ?>
                                        <a href="<?php echo htmlspecialchars($project->repo_link); ?>" target="_blank" rel="noreferrer" class="btn btn-outline-secondary flex-grow-1 bg-white">
                                            <i class="bi bi-github me-1"></i> Código
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">
                    <p>Aún no hay proyectos para mostrar.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CONTACTO -->
<section id="contacto" class="section-padding bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Ponte en Contacto</h2>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card contact-card p-4 p-md-5 bg-white">
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Nombre</label>
                            <input type="text" class="form-control bg-gray-50 border-0 py-2 px-3" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Correo Electrónico</label>
                            <input type="email" class="form-control bg-gray-50 border-0 py-2 px-3" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-medium">Asunto</label>
                            <input type="text" class="form-control bg-gray-50 border-0 py-2 px-3" id="subject" name="subject" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label fw-medium">Mensaje</label>
                            <textarea class="form-control bg-gray-50 border-0 py-2 px-3" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-send me-2"></i>Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
