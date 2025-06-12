<?php
require_once '../controller/dashboard_controller.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$categorias = obtenerCategoriasConEventos();
$usuario_id = $_SESSION['usuario_id'];
$esOrganizador = esOrganizador($usuario_id);
$esCliente = esCliente($usuario_id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Dashboard: Categorías y Eventos</h2>
    <?php foreach ($categorias as $cat): ?>
        <h3>Categoría: <?php echo htmlspecialchars($cat->desc); ?></h3>
        <?php if (count($cat->eventos) > 0): ?>
            <ul>
            <?php foreach ($cat->eventos as $ev): ?>
                <li><?php echo htmlspecialchars($ev->titulo) . ' - ' . htmlspecialchars($ev->fecha) . ' - ' . htmlspecialchars($ev->lugar); ?>
                    <?php if (strtotime($ev->fecha) > time() && $esCliente): ?>
                        <form action="comprar_ticket.php" method="get" style="display:inline;">
                            <input type="hidden" name="evento_id" value="<?php echo $ev->id; ?>">
                            <button type="submit">Comprar</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay eventos para esta categoría.</p>
        <?php endif; ?>
    <?php endforeach; ?>
    <a href="../controller/logout_controller.php">Cerrar sesión</a>
    <a href="../view/perfil_cliente.php">Mi perfil</a>
    <?php if ($esOrganizador): ?>
        <a href="../view/crear_evento.php">Crear nuevo evento</a>
    <?php endif; ?>
</body>
</html>
