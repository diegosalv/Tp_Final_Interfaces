<?php
include 'db.php';
$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$password = $data->password;

$stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        echo json_encode(["status" => "success", "id" => $id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Contraseña incorrecta"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
}
?>