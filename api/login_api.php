<?php
// api/login_api.php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->username) && !empty($data->password)) {
    try {
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $data->username);
        $stmt->execute();
        
        $user = $stmt->fetch();

        if ($user && password_verify($data->password, $user->password_hash)) {
            // Autenticación exitosa
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            
            echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso', 'redirect' => 'dashboard.php']);
        } else {
            // Credenciales incorrectas
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Usuario o contraseña incorrectos.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error en el servidor.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Por favor, ingrese usuario y contraseña.']);
}
?>
