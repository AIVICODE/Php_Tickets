<?php
require_once '../conection/sql.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprar Ticket</title>
</head>
<body>
    <h2>Comprar Ticket</h2>
    <?php if (isset($msg)) echo '<p>' . htmlspecialchars($msg) . '</p>'; ?>
    <form method="post">
        <label>Evento:
            <select name="evento_id" required>
                <option value="">Seleccione un evento</option>
                <?php foreach ($eventos as $ev): ?>
                    <option value="<?php echo $ev['id']; ?>"><?php echo htmlspecialchars($ev['titulo']) . ' - ' . htmlspecialchars($ev['fecha']); ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Cantidad de personas:
            <input type="number" name="cantidad" min="1" required>
        </label><br>
        <label>Método de pago:
            <select name="metodo_pago" required>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Efectivo">Efectivo</option>
            </select>
        </label><br>
        <button type="submit">Comprar</button>
    </form>
    <a href="dashboard.php">Volver al dashboard</a>
</body>
</html>
