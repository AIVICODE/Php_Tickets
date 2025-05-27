<?php
require_once '../conection/sql.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
// Solo organizador puede crear eventos
$conn = conectar();
$usuario_id = $_SESSION['usuario_id'];
$res = mysqli_query($conn, "SELECT * FROM Organizador WHERE id = $usuario_id");
if (mysqli_num_rows($res) == 0) {
    desconectar($conn);
    die('Acceso denegado. Solo organizadores pueden crear eventos.');
}
// Obtener categorías para el select
$categorias = array();
$resCat = mysqli_query($conn, 'SELECT * FROM Categoria');
while ($row = mysqli_fetch_assoc($resCat)) {
    $categorias[] = $row;
}
desconectar($conn);
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
