<?php
// Dashboard básico: muestra categorías y eventos asociados
require_once '../clases/categoria.php';
require_once '../clases/evento.php';
require_once '../conection/sql.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$conn = conectar();
// Obtener categorías
$categorias = array();
$resCat = mysqli_query($conn, 'SELECT * FROM Categoria');
while ($row = mysqli_fetch_assoc($resCat)) {
    $cat = new Categoria();
    $cat->id = $row['id'];
    $cat->desc = $row['descripcion'];
    $cat->eventos = array();
    // Obtener eventos asociados a la categoría
    $resEv = mysqli_query($conn, 'SELECT * FROM Evento WHERE categoria_id = ' . intval($row['id']));
    while ($rowEv = mysqli_fetch_assoc($resEv)) {
        $ev = new Evento();
        $ev->id = $rowEv['id'];
        $ev->titulo = $rowEv['titulo'];
        $ev->desc = $rowEv['descripcion'];
        $ev->fecha = $rowEv['fecha'];
        $ev->lugar = $rowEv['lugar'];
        $cat->eventos[] = $ev;
    }
    $categorias[] = $cat;
}
desconectar($conn);
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
                    <?php if (strtotime($ev->fecha) > time()): ?>
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
    <a href="logout.php">Cerrar sesión</a>
    <a href="perfil_cliente.php">Mi perfil</a>
    <?php
    // Mostrar botón solo si es organizador
    $conn = conectar();
    $usuario_id = $_SESSION['usuario_id'];
    $res = mysqli_query($conn, "SELECT * FROM Organizador WHERE id = $usuario_id");
    if (mysqli_num_rows($res) > 0) {
        echo '<a href="crear_evento.php">Crear nuevo evento</a>';
    }
    desconectar($conn);
    ?>
</body>
</html>
