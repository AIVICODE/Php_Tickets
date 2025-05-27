<?php
require_once __DIR__ . '/../controller/crear_evento_controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Evento</title>
</head>
<body>
    <h2>Crear Nuevo Evento</h2>
    <form method="post" action="procesar_evento.php" enctype="multipart/form-data">
        <label>Título: <input type="text" name="titulo" required></label><br>
        <label>Descripción: <textarea name="descripcion" required></textarea></label><br>
        <label>Lugar: <input type="text" name="lugar" required></label><br>
        <label>Fecha: <input type="datetime-local" name="fecha" required></label><br>
        <label>Categoría:
            <select name="categoria_id" required>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['descripcion']); ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Precio de entrada: <input type="number" name="precio" step="0.01" min="0" required></label><br>
        <label>Cantidad máxima de personas: <input type="number" name="cupo" min="1" required></label><br>
        <label>Imágenes relevantes: <input type="file" name="imagenes[]" accept="image/*" multiple></label><br>
        <button type="submit">Crear Evento</button>
    </form>
    <a href="dashboard.php">Volver al Dashboard</a>
</body>
</html>
