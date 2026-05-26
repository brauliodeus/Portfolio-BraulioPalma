<?php
// includes/db.php

$host = 'localhost';
$dbname = 'portfolio_db';
$username = 'root';
$password = ''; // Cambiar si la base de datos local tiene contraseña

try {
    // Crear nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Configurar el modo de fetch por defecto a objetos
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

} catch (PDOException $e) {
    // Si hay un error, detener la ejecución y mostrar el mensaje
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>