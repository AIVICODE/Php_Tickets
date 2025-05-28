<?php
require_once __DIR__ . '/../controller/login_controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if ($mensaje) echo '<p>' . htmlspecialchars($mensaje) . '</p>'; ?>
    <form method="post">
        <label>Nickname: <input type="text" name="nickname" required></label><br>
        <label>Contraseña: <input type="password" name="pass" required></label><br>
        <button type="submit">Ingresar</button>
    </form>
    <a href="registro.php">¿No tienes cuenta? Regístrate</a>
</body>
</html>
