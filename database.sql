USE bpalma2025_db1;

-- Tabla de usuarios (administradores)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de proyectos
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    demo_link VARCHAR(255),
    repo_link VARCHAR(255),
    is_locked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de mensajes de contacto
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar usuario administrador por defecto
-- Usuario: admin
-- Contraseña: password (hasheada con bcrypt)
INSERT INTO users (username, password_hash) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insertar proyectos de ejemplo basados en el wireframe
INSERT INTO projects (title, description, image_url, demo_link, repo_link) VALUES 
('SteamStorm', 'Aplicación web Full Stack diseñada para centralizar el descubrimiento de videojuegos. Permite a los usuarios consultar datos en tiempo real, gestionar una lista de deseados personalizada y compartir reseñas con la comunidad.', 'https://images.unsplash.com/photo-1583508915901-b5f84c1dcde1?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsYXB0b3AlMjBjb2RpbmclMjB3ZWIlMjBkZXZlbG9wbWVudHxlbnwxfHx8fDE3Nzg1MDkwNzl8MA&ixlib=rb-4.1.0&q=80&w=1080', '#', 'https://github.com/brauliodeus/SteamStorm'),
('API - Centro de estudiantes', 'API RESTful para la gestión de encuestas y votaciones del Centro de Estudiantes. Permite a los administradores crear encuestas complejas y a los estudiantes responderlas de forma segura.', 'https://images.unsplash.com/photo-1583508915901-b5f84c1dcde1?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsYXB0b3AlMjBjb2RpbmclMjB3ZWIlMjBkZXZlbG9wbWVudHxlbnwxfHx8fDE3Nzg1MDkwNzl8MA&ixlib=rb-4.1.0&q=80&w=1080', '#', 'https://github.com/brauliodeus/API-Centro-de-estudiantes');
