<?php
require_once __DIR__ . '/../conection/sql.php';
require_once __DIR__ . '/../model/organizador.php';
require_once __DIR__ . '/../model/evento.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit;
}
$usuario_id = $_SESSION['usuario_id'];
$conn = conectar();
if (!Organizador::esOrganizador($conn, $usuario_id)) {
    desconectar($conn);
    $mensaje = 'Acceso denegado.';
    $exito = false;
    return;
}
$mensaje = '';
$exito = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $lugar = mysqli_real_escape_string($conn, $_POST['lugar']);
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);
    $categoria_id = intval($_POST['categoria_id']);
    $precio = floatval($_POST['precio']);
    $cupo = intval($_POST['cupo']);
    $estado = 'activo';
    // Delegar a Evento
    $evento = new Evento();
    $res = $evento->crearEvento($conn, $titulo, $descripcion, $fecha, $lugar, $precio, $cupo, $estado, $usuario_id, $categoria_id);
    if ($res['ok']) {
        $evento_id = $res['evento_id'];
        // Guardar imágenes
        $uploaddir = "../images/";
        $uploadfile = $uploaddir . basename($_FILES['img']['name']); // aqui esta el nombre de la imagen
        move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile);
        $sql= "INSERT INTO eventoimagen (evento_id, url_imagen) VALUES ($evento_id, '$uploadfile')";
        modifico($conn,$sql);
        $mensaje = 'Evento creado correctamente.';
        $exito = true;
    } else {
        $mensaje = 'Error al crear evento.';
        $exito = false;
    }
} else {
    header('Location: ../view/crear_evento.php');
    exit;
}
desconectar($conn);
