<?php
require_once __DIR__ . '/../conection/sql.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit;
}
// Solo organizador puede crear eventos
$conn = conectar();
$usuario_id = $_SESSION['usuario_id'];
$res = mysqli_query($conn, "SELECT * FROM Organizador WHERE id = $usuario_id");
if (mysqli_num_rows($res) == 0) {
    desconectar($conn);
    die('Acceso denegado. Solo organizadores pueden crear eventos.');
}
// Obtener categorías para el select
$categorias = array();
$resCat = mysqli_query($conn, 'SELECT * FROM Categoria');
while ($row = mysqli_fetch_assoc($resCat)) {
    $categorias[] = $row;
}
desconectar($conn);
