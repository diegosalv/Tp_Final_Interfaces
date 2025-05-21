<?php
$host = "sql201.infinityfree.com";
$user = "if0_39045582";
$password = "nCwqxkrDKA";
$dbname = "if0_39045582_fitapp";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>