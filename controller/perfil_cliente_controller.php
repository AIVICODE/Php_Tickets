<?php
require_once __DIR__ . '/../conection/sql.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit;
}
$conn = conectar();
$usuario_id = $_SESSION['usuario_id'];
// Obtener datos del usuario
$resUser = mysqli_query($conn, "SELECT nombre, email, imagen FROM Usuario WHERE id = $usuario_id");
$user = mysqli_fetch_assoc($resUser);
// Obtener eventos comprados
$resTickets = mysqli_query($conn, "SELECT E.titulo, E.fecha, E.lugar, T.cantidad FROM Ticket T JOIN Evento E ON T.evento_id = E.id WHERE T.cliente_id = $usuario_id");
$eventos = array();
while ($row = mysqli_fetch_assoc($resTickets)) {
    $eventos[] = $row;
}
desconectar($conn);
