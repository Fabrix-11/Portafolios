<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = trim($_POST['nombre'] ?? '');
    $correo  = trim($_POST['correo'] ?? '');
    $asunto  = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    // Validaciones básicas
    if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Por favor, completa todos los campos obligatorios.'
        ]);
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'El formato del correo electrónico no es válido.'
        ]);
        exit;
    }

    try {
        $sql = "INSERT INTO mensajes_contacto (nombre, correo, asunto, mensaje) VALUES (:nombre, :correo, :asunto, :mensaje)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre'  => htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'),
            ':correo'  => htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'),
            ':asunto'  => htmlspecialchars($asunto, ENT_QUOTES, 'UTF-8'),
            ':mensaje' => htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8')
        ]);

        echo json_encode([
            'status' => 'success',
            'message' => '¡Mensaje enviado y registrado correctamente!'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ocurrió un error al guardar el mensaje en la base de datos.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido.'
    ]);
}
?>