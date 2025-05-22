<?php
// Mostrar errores para depuración (InfinityFree a veces los oculta)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

// Leer los datos del cuerpo JSON
$data = json_decode(file_get_contents("php://input"));

// Validar si llegaron los datos
if (!isset($data->username) || !isset($data->password)) {
    echo json_encode(["status" => "error", "message" => "Faltan datos"]);
    exit;
}

$username = $data->username;
$password = password_hash($data->password, PASSWORD_BCRYPT);

// Verificar si ya existe el usuario
$check = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "El usuario ya existe"]);
    exit;
}

// Insertar usuario nuevo
$stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Usuario registrado"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}
?>
