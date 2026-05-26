<?php
// includes/auth.php
session_start();

// Función para verificar si el usuario está logueado
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Función para proteger rutas. Si no está logueado, redirige al login.
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Función para verificar si hay una sesión activa por AJAX
function requireLoginAjax() {
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
        exit;
    }
}
?>
