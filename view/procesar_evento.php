<?php
require_once __DIR__ . '/../controller/procesar_evento_controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesar Evento</title>
</head>
<body>
    <?php if ($exito): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
        <a href="dashboard.php">Volver al Dashboard</a>
    <?php else: ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
        <a href="crear_evento.php">Volver</a>
    <?php endif; ?>
</body>
</html>
