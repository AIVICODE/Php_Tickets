<?php
require_once __DIR__ . '/../controller/registro_controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <?php if ($mensaje) echo '<p>' . htmlspecialchars($mensaje) . '</p>'; ?>
    <?php if (!$exito): ?>
    <form method="post" enctype="multipart/form-data">
        <label>Nickname: <input type="text" name="nickname" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Contraseña: <input type="password" name="pass" required></label><br>
        <label>Foto de perfil: <input type="file" name="img" accept="image/*"></label><br>
        <label>Tipo:
            <select name="tipo" required>
                <option value="cliente">Cliente</option>
                <option value="organizador">Organizador</option>
            </select>
        </label><br>
        <button type="submit">Registrarse</button>
    </form>
    <?php endif; ?>
    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
</body>
</html>
