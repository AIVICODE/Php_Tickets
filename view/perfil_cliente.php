<?php
require_once __DIR__ . '/../controller/perfil_cliente_controller.php';
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
