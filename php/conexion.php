<?php
// CONFIGURACIÓN LOCAL (XAMPP)
$host = 'localhost';
$dbname = 'portafolio_db';
$username = 'root';
$password = '';



try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de conexión a la base de datos.'
    ]);
    exit;
}
?>