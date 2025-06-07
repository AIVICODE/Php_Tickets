<?php
require_once __DIR__ . '/../conection/sql.php';
require_once __DIR__ . '/../model/evento.php';
require_once __DIR__ . '/../model/ticket.php';
require_once __DIR__ . '/../model/cliente.php';
require_once __DIR__ . '/../model/usuario.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit;
}
$conn = conectar();
$msg = '';
$evento_id = isset($_GET['evento_id']) ? intval($_GET['evento_id']) : 0;
$evento = null;
if ($evento_id) {
    $evento = Evento::getEventoDisponible($conn, $evento_id);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $evento) {
    $cantidad = intval($_POST['cantidad']);
    $metodo_pago = $_POST['metodo_pago'];
    $cliente_id = $_SESSION['usuario_id'];
    $totalPago = $cantidad * floatval($evento->precio);
    $cupo = $evento->getCupo();

    if($cupo>=$cantidad){
        // Usar el método del modelo Ticket
        $ticket = new Ticket();
        list($ok, $result) = $ticket->registrarCompra($conn, $cliente_id, $evento_id, $cantidad, $totalPago, $metodo_pago);
        if ($ok) {
            // Enviar email de confirmación
            $resUser = mysqli_query($conn, "SELECT email FROM Usuario WHERE id = $cliente_id");
            $rowUser = mysqli_fetch_assoc($resUser);
            $email = $rowUser['email'];
            $asunto = "Confirmación de compra de ticket";
            $mensaje = "Su compra de $cantidad ticket(s) para el evento #$evento_id fue realizada con éxito.";
            mail($email, $asunto, $mensaje);
            $msg = "¡Compra realizada! Se ha enviado un email de confirmación.";
        } else {
            $msg = $result;
        }
    }
}
desconectar($conn);
?>
