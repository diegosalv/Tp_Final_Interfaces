<?php
include 'db.php';
$id_usuario = $_GET['id_usuario'];
$result = $conn->query("SELECT * FROM medidas WHERE id_usuario = $id_usuario ORDER BY fecha DESC LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["status" => "error", "message" => "No se encontraron registros"]);
}
?>