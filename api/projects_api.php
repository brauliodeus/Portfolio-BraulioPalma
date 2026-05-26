<?php
// api/projects_api.php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Verificar autenticación
requireLoginAjax();

$method = $_SERVER['REQUEST_METHOD'];

// Leer los datos JSON de entrada (Method Spoofing para hostings que bloquean PUT/PATCH/DELETE)
$raw_input = file_get_contents("php://input");
$data = json_decode($raw_input);

if ($method === 'POST' && $data && isset($data->_method)) {
    $method = strtoupper($data->_method);
}

switch ($method) {
    case 'GET':
        // Listar proyectos
        try {
            if (isset($_GET['id'])) {
                $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id LIMIT 1");
                $stmt->bindParam(':id', $_GET['id']);
                $stmt->execute();
                $project = $stmt->fetch();
                echo json_encode(['status' => 'success', 'data' => $project]);
            } else {
                $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
                $projects = $stmt->fetchAll();
                echo json_encode(['status' => 'success', 'data' => $projects]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error al obtener proyectos']);
        }
        break;

    case 'POST':
        // Crear proyecto
        if (!empty($data->title) && !empty($data->description) && !empty($data->image_url)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_url, demo_link, repo_link) VALUES (:title, :description, :image_url, :demo_link, :repo_link)");
                $stmt->bindValue(':title', htmlspecialchars(strip_tags($data->title)));
                $stmt->bindValue(':description', htmlspecialchars(strip_tags($data->description)));
                $stmt->bindValue(':image_url', filter_var($data->image_url, FILTER_SANITIZE_URL));
                $stmt->bindValue(':demo_link', filter_var($data->demo_link ?? '', FILTER_SANITIZE_URL));
                $stmt->bindValue(':repo_link', filter_var($data->repo_link ?? '', FILTER_SANITIZE_URL));
                
                if ($stmt->execute()) {
                    http_response_code(201);
                    echo json_encode(['status' => 'success', 'message' => 'Proyecto creado con éxito']);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Error al crear el proyecto']);
                }
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error de base de datos']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Faltan campos obligatorios']);
        }
        break;

    case 'PUT':
        // Actualizar proyecto
        if (!empty($data->id) && !empty($data->title) && !empty($data->description) && !empty($data->image_url)) {
            try {
                $checkStmt = $pdo->prepare("SELECT is_locked FROM projects WHERE id = :id");
                $checkStmt->bindValue(':id', $data->id);
                $checkStmt->execute();
                $proj = $checkStmt->fetch();
                if ($proj && $proj->is_locked) {
                    http_response_code(403);
                    echo json_encode(['status' => 'error', 'message' => 'El proyecto está bloqueado y no puede ser editado.']);
                    break;
                }

                $stmt = $pdo->prepare("UPDATE projects SET title = :title, description = :description, image_url = :image_url, demo_link = :demo_link, repo_link = :repo_link WHERE id = :id");
                $stmt->bindValue(':title', htmlspecialchars(strip_tags($data->title)));
                $stmt->bindValue(':description', htmlspecialchars(strip_tags($data->description)));
                $stmt->bindValue(':image_url', filter_var($data->image_url, FILTER_SANITIZE_URL));
                $stmt->bindValue(':demo_link', filter_var($data->demo_link ?? '', FILTER_SANITIZE_URL));
                $stmt->bindValue(':repo_link', filter_var($data->repo_link ?? '', FILTER_SANITIZE_URL));
                $stmt->bindValue(':id', $data->id);
                
                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Proyecto actualizado con éxito']);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el proyecto']);
                }
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error de base de datos']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Faltan campos obligatorios']);
        }
        break;

    case 'DELETE':
        // Eliminar proyecto
        $delete_id = isset($_GET['id']) ? $_GET['id'] : (isset($data->id) ? $data->id : null);
        if ($delete_id) {
            try {
                $checkStmt = $pdo->prepare("SELECT is_locked FROM projects WHERE id = :id");
                $checkStmt->bindValue(':id', $delete_id);
                $checkStmt->execute();
                $proj = $checkStmt->fetch();
                if ($proj && $proj->is_locked) {
                    http_response_code(403);
                    echo json_encode(['status' => 'error', 'message' => 'El proyecto está bloqueado y no puede ser eliminado.']);
                    break;
                }

                $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
                $stmt->bindParam(':id', $delete_id);
                
                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Proyecto eliminado con éxito']);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el proyecto']);
                }
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error de base de datos']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID de proyecto no proporcionado']);
        }
        break;

        break;

    case 'PATCH':
        // Alternar bloqueo
        if (!empty($data->id) && isset($data->is_locked)) {
            try {
                $stmt = $pdo->prepare("UPDATE projects SET is_locked = :is_locked WHERE id = :id");
                $stmt->bindValue(':is_locked', $data->is_locked ? 1 : 0, PDO::PARAM_INT);
                $stmt->bindValue(':id', $data->id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Estado de bloqueo actualizado']);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el estado']);
                }
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error de base de datos']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
        break;
}
?>
