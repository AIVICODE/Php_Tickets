<?php
require_once '../conection/sql.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$conn = conectar();
$usuario_id = $_SESSION['usuario_id'];
// Obtener datos del usuario
$resUser = mysqli_query($conn, "SELECT nombre, email, imagen FROM Usuario WHERE id = $usuario_id");
$user = mysqli_fetch_assoc($resUser);
// Obtener eventos comprados
$resTickets = mysqli_query($conn, "SELECT E.titulo, E.fecha, E.lugar, T.cantidad FROM Ticket T JOIN Evento E ON T.evento_id = E.id WHERE T.usuario_id = $usuario_id");
$eventos = array();
while ($row = mysqli_fetch_assoc($resTickets)) {
    $eventos[] = $row;
}
desconectar($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
</head>
<body>
    <h2>Mi Perfil</h2>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user['nombre']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <?php if (!empty($user['imagen'])): ?>
        <img src="<?php echo htmlspecialchars($user['imagen']); ?>" alt="Imagen de perfil" width="120" height="120">
    <?php else: ?>
        <p>No hay imagen de perfil.</p>
    <?php endif; ?>
    <h3>Eventos comprados</h3>
    <?php if (count($eventos) > 0): ?>
        <ul>
        <?php foreach ($eventos as $ev): ?>
            <li><?php echo htmlspecialchars($ev['titulo']) . ' - ' . htmlspecialchars($ev['fecha']) . ' - ' . htmlspecialchars($ev['lugar']) . ' (Cantidad: ' . $ev['cantidad'] . ')'; ?></li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No has comprado entradas aún.</p>
    <?php endif; ?>
    <a href="dashboard.php">Volver al dashboard</a>
</body>
</html>
