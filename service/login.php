<?php
require_once '../conection/sql.php';

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
        header('Location: dashboard.php');
        exit;
    } else {
        $mensaje = 'Nickname o contraseña incorrectos.';
    }
    desconectar($conn);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if ($mensaje) echo '<p>' . $mensaje . '</p>'; ?>
    <form method="post">
        <label>Nickname: <input type="text" name="nickname" required></label><br>
        <label>Contraseña: <input type="password" name="pass" required></label><br>
        <button type="submit">Ingresar</button>
    </form>
    <a href="registro.php">¿No tienes cuenta? Regístrate</a>
</body>
</html>
