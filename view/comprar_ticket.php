<?php
require_once __DIR__ . '/../controller/comprar_ticket_controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprar Ticket</title>
</head>
<body>
    <h2>Comprar Ticket</h2>
    <?php if ($msg) echo '<p>' . htmlspecialchars($msg) . '</p>'; ?>
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
