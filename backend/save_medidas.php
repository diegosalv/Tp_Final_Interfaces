<?php
// Mostrar errores para depurar
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

// Obtener y decodificar los datos del cuerpo de la petición
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id_usuario)) {
    echo json_encode(["status" => "error", "message" => "Faltan datos o JSON inválido"]);
    exit;
}

// Validación mínima
$campos = ['pecho', 'brazo', 'brazo_der', 'antebrazo', 'antebrazo_der', 'cintura', 'cuello', 'pierna_izq', 'pierna_der', 'gemelos', 'gemelos_izq'];

foreach ($campos as $campo) {
    if (!isset($data->$campo)) {
        echo json_encode(["status" => "error", "message" => "Falta el campo: $campo"]);
        exit;
    }
}

// Preparar la consulta SQL
$stmt = $conn->prepare("
    INSERT INTO medidas (
        id_usuario, pecho, brazo, brazo_der, antebrazo, antebrazo_der,
        cintura, cuello, pierna_izq, pierna_der, gemelos, gemelos_izq
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// Asociar los parámetros
$stmt->bind_param(
    "iddddddddddd",
    $data->id_usuario,
    $data->pecho,
    $data->brazo,
    $data->brazo_der,
    $data->antebrazo,
    $data->antebrazo_der,
    $data->cintura,
    $data->cuello,
    $data->pierna_izq,
    $data->pierna_der,
    $data->gemelos,
    $data->gemelos_izq
);

// Ejecutar e informar el resultado
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Medidas guardadas correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}
?>
