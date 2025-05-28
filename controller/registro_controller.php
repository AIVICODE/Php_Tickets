<?php
require_once __DIR__ . '/../conection/sql.php';
require_once __DIR__ . '/../model/usuario.php';
require_once __DIR__ . '/../model/cliente.php';
require_once __DIR__ . '/../model/organizador.php';

$mensaje = '';
$exito = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = trim($_POST['nickname']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $tipo = $_POST['tipo'];
    $img = '';
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $img = 'imagenes/' . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], __DIR__ . '/../../imagenes/' . basename($_FILES['img']['name']));
    }
    $conn = conectar();
    $res = Usuario::existeUsuario($conn, $nickname, $email);
    if ($res) {
        $mensaje = 'El nickname o email ya existen.';
    } else {
        $fecha = date('Y-m-d H:i:s');
        $usuario = new Usuario();
        $id = $usuario->registrar($conn, $nickname, $email, $pass, $fecha, $img);
        if ($id) {
            if ($tipo === 'cliente') {
                Cliente::registrarCliente($conn, $id);
            } else {
                Organizador::registrarOrganizador($conn, $id);
            }
            $mensaje = 'Registro exitoso. Ahora puedes iniciar sesión.';
            $exito = true;
        } else {
            $mensaje = 'Error al registrar usuario.';
        }
    }
    desconectar($conn);
}
?>
