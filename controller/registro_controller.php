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
    //imagen
    $uploaddir = '../images/';
    $uploadfile = $uploaddir . basename($_FILES['img']['name']); // aqui esta el nombre de la imagen
    move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile);
    //echo $uploadfile;
    //fin de imagen
    $conn = conectar();
    $res = Usuario::existeUsuario($conn, $nickname, $email);
    if ($res) {
        $mensaje = 'El nickname o email ya existen.';
    } else {
        $fecha = date('Y-m-d H:i:s');
        $usuario = new Usuario();
        $id = $usuario->registrar($conn, $nickname, $email, $pass, $fecha, $uploadfile);
        if ($id) {
            if ($tipo === 'cliente') {
                Cliente::registrarCliente($conn, $id);
            } else {
                Organizador::registrarOrganizador($conn, $id);
            }
            $mensaje = 'Registro exitoso. Ahora puedes iniciar sesión.';
            $exito = true;
            header("location: ../view/registro_completado.html");
        } else {
            $mensaje = 'Error al registrar usuario.';
        }
    }
    desconectar($conn);
}
?>
