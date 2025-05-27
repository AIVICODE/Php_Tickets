<?php
require_once '../conection/sql.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = trim($_POST['nickname']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $tipo = $_POST['tipo'];
    $img = '';
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $img = 'imagenes/' . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], '../../imagenes/' . basename($_FILES['img']['name']));
    }
    $conn = conectar();
    // Validar unicidad
    $sql = "SELECT * FROM Usuario WHERE nombre = '" . mysqli_real_escape_string($conn, $nickname) . "' OR email = '" . mysqli_real_escape_string($conn, $email) . "'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $mensaje = 'El nickname o email ya existen.';
    } else {
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO Usuario (nombre, email, contraseña, fechaRegistro, imagen) VALUES ('" .
            mysqli_real_escape_string($conn, $nickname) . "', '" .
            mysqli_real_escape_string($conn, $email) . "', '" .
            mysqli_real_escape_string($conn, $pass) . "', '" .
            $fecha . "', '" .
            mysqli_real_escape_string($conn, $img) . "')";
        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            if ($tipo === 'cliente') {
                $sql2 = "INSERT INTO Cliente (id) VALUES ($id)";
            } else {
                $sql2 = "INSERT INTO Organizador (id) VALUES ($id)";
            }
            mysqli_query($conn, $sql2);
            $mensaje = 'Registro exitoso. Ahora puedes iniciar sesión.';
        } else {
            $mensaje = 'Error al registrar usuario.';
        }
    }
    desconectar($conn);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <?php if ($mensaje) echo '<p>' . $mensaje . '</p>'; ?>
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
    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
</body>
</html>
