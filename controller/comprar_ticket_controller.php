<?php
require_once __DIR__ . '/../conection/sql.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit;
}
$conn = conectar();
// Obtener eventos que no hayan iniciado
$hoy = date('Y-m-d H:i:s');
$resEv = mysqli_query($conn, "SELECT * FROM Evento WHERE fecha > '$hoy'");
$eventos = array();
while ($row = mysqli_fetch_assoc($resEv)) {
    $eventos[] = $row;
}
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evento_id = intval($_POST['evento_id']);
    $cantidad = intval($_POST['cantidad']);
    $metodo_pago = $_POST['metodo_pago'];
    $usuario_id = $_SESSION['usuario_id'];
    // Registrar compra (tabla Ticket)
    $query = "INSERT INTO Ticket (usuario_id, evento_id, cantidad, metodo_pago, fecha_compra) VALUES ($usuario_id, $evento_id, $cantidad, '$metodo_pago', NOW())";
    if (mysqli_query($conn, $query)) {
        // Obtener email del usuario
        $resUser = mysqli_query($conn, "SELECT email FROM Usuario WHERE id = $usuario_id");
        $rowUser = mysqli_fetch_assoc($resUser);
        $email = $rowUser['email'];
        // Enviar email (función simple mail)
        $asunto = "Confirmación de compra de ticket";
        $mensaje = "Su compra de $cantidad ticket(s) para el evento #$evento_id fue realizada con éxito.";
        mail($email, $asunto, $mensaje);
        $msg = "¡Compra realizada! Se ha enviado un email de confirmación.";
    } else {
        $msg = "Error al procesar la compra.";
    }
}
desconectar($conn);
