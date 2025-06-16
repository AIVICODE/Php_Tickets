<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php
require_once __DIR__ . '/../controller/comprar_ticket_controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprar Ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylesheets/dashboard/body.css">
</head>
</head>
<body>
    <header>
        <?php include __DIR__ . '/components/navbar.php'; ?>
    </header>

    <h2>Comprar Ticket</h2>
    <?php if ($msg) echo '<p>' . htmlspecialchars($msg) . '</p>'; ?>
    <?php if ($evento): ?>
    <form method="post">
        <input type="hidden" name="evento_id" value="<?php echo is_object($evento) ? $evento->id : (isset($evento['id']) ? $evento['id'] : ''); ?>">
        <p><strong>Evento:</strong> <?php echo is_object($evento) ? htmlspecialchars($evento->titulo) . ' - ' . htmlspecialchars($evento->fecha) : (isset($evento['titulo']) ? htmlspecialchars($evento['titulo']) . ' - ' . htmlspecialchars($evento['fecha']) : ''); ?></p>
        <label>Cantidad de personas:
            <input type="number" name="cantidad" min="1" max='<?php $evento->getCupo(); ?>' required>
            <?php echo "Solo quedan " . $evento->getCupo() . " entradas disponibles.";?>
        </label><br>
        <label>Método de pago:
            <select name="metodo_pago" required>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Efectivo">Efectivo</option>
            </select>
        </label><br>
        <button type="submit">Comprar</button>
    </form>
    <?php else: ?>
        <p>No se encontró el evento o ya no está disponible.</p>
    <?php endif; ?>
    <a href="dashboard.php">Volver al dashboard</a>
</body>
</html>
