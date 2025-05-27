<?php
require_once __DIR__ . '/../conection/sql.php';
session_start();
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = trim($_POST['nickname']);
    $pass = $_POST['pass'];
    $conn = conectar();
    $sql = "SELECT * FROM Usuario WHERE nombre = '" . mysqli_real_escape_string($conn, $nickname) . "' AND contraseña = '" . mysqli_real_escape_string($conn, $pass) . "'";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($res)) {
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['usuario_nombre'] = $row['nombre'];
        $mensaje = 'Login exitoso. Bienvenido, ' . $row['nombre'] . '!';
        header('Location: ../view/dashboard.php');
        exit;
    } else {
        $mensaje = 'Nickname o contraseña incorrectos.';
    }
    desconectar($conn);
}
