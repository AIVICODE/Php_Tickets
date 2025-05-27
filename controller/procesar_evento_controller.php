<?php
require_once __DIR__ . '/../conection/sql.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit;
}
$usuario_id = $_SESSION['usuario_id'];
$conn = conectar();
$res = mysqli_query($conn, "SELECT * FROM Organizador WHERE id = $usuario_id");
if (mysqli_num_rows($res) == 0) {
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
    $sql = "INSERT INTO Evento (titulo, descripcion, fecha, lugar, precio, cupo, estado, organizador_id, categoria_id) VALUES ('$titulo', '$descripcion', '$fecha', '$lugar', $precio, $cupo, '$estado', $usuario_id, $categoria_id)";
    if (mysqli_query($conn, $sql)) {
        $evento_id = mysqli_insert_id($conn);
        // Guardar imágenes
        if (!empty($_FILES['imagenes']['name'][0])) {
            $total = count($_FILES['imagenes']['name']);
            for ($i = 0; $i < $total; $i++) {
                $tmp = $_FILES['imagenes']['tmp_name'][$i];
                $name = basename($_FILES['imagenes']['name'][$i]);
                $destino = __DIR__ . '/../../imagenes/' . $name;
                if (move_uploaded_file($tmp, $destino)) {
                    $url = 'imagenes/' . $name;
                    mysqli_query($conn, "INSERT INTO EventoImagen (evento_id, url_imagen) VALUES ($evento_id, '$url')");
                }
            }
        }
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
