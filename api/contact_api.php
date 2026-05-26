<?php
// api/contact_api.php
header('Content-Type: application/json');
require_once '../includes/db.php';

// Verificar método de solicitud
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    exit;
}

// Obtener datos JSON del cuerpo de la petición
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->email) && !empty($data->subject) && !empty($data->message)) {
    
    // Validar email
    if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'El formato del correo es inválido.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        
        // Limpiar datos y vincular parámetros
        $stmt->bindValue(':name', htmlspecialchars(strip_tags($data->name)));
        $stmt->bindValue(':email', htmlspecialchars(strip_tags($data->email)));
        $stmt->bindValue(':subject', htmlspecialchars(strip_tags($data->subject)));
        $stmt->bindValue(':message', htmlspecialchars(strip_tags($data->message)));

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado correctamente.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Hubo un error al enviar el mensaje.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error de base de datos.']);
    }

} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios.']);
}
?>
