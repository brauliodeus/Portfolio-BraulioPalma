<?php
// login.php
require_once 'includes/auth.php';

// Si ya está logueado, redirigir al dashboard
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BraulioDev</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card login-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary-custom mb-1">BraulioDev</h2>
                    <p class="text-muted">Panel de Administración</p>
                </div>

                <form id="loginForm">
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-start-0" id="username" name="username" placeholder="Usuario" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" class="form-control bg-light border-start-0" id="password" name="password" placeholder="Contraseña" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3">
                        Iniciar Sesión
                    </button>

                    <div class="text-center">
                        <a href="index.php" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left me-1"></i>Volver al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = loginForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validando...';

            const formData = {
                username: document.getElementById('username').value,
                password: document.getElementById('password').value
            };

            fetch('api/login_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Acceso Denegado',
                        text: data.message,
                        confirmButtonColor: '#0d6efd'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo contactar con el servidor.',
                    confirmButtonColor: '#0d6efd'
                });
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    }
});
</script>
</body>
</html>
