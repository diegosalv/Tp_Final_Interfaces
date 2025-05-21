<?php
include 'db.php';
$data = json_decode(file_get_contents("php://input"));
$id_usuario = $data->id_usuario;
$stmt = $conn->prepare("INSERT INTO medidas (id_usuario, pecho, brazo, brazo_der, antebrazo, antebrazo_der, cintura, cuello, pierna_izq, pierna_der, gemelos, gemelos_izq)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iddddddddddd", $id_usuario, $data->pecho, $data->brazo, $data->brazo_der, $data->antebrazo, $data->antebrazo_der,
$data->cintura, $data->cuello, $data->pierna_izq, $data->pierna_der, $data->gemelos, $data->gemelos_izq);
if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}
?>