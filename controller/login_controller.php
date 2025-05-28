<?php
require_once __DIR__ . '/../conection/sql.php';
require_once __DIR__ . '/../model/usuario.php';
session_start();
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = trim($_POST['nickname']);
    $pass = $_POST['pass'];
    $conn = conectar();
    $usuario = Usuario::login($conn, $nickname, $pass);
    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['usuario_nombre'] = $usuario->getNom();
        $mensaje = 'Login exitoso. Bienvenido, ' . $usuario->getNom() . '!';
        header('Location: ../view/dashboard.php');
        exit;
    } else {
        $mensaje = 'Nickname o contraseña incorrectos.';
    }
    desconectar($conn);
}
?>
