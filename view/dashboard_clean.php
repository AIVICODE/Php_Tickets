<?php
require_once '../controller/dashboard_controller.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$esOrganizador = esOrganizador($usuario_id);
$esCliente = esCliente($usuario_id);


$buscar = isset($_GET['buscar_evento']) ? trim($_GET['buscar_evento']) : '';
if ($buscar !== '') {
    $categorias = buscarEventosPorTituloOCategoria($buscar);
} else {
    $categorias = obtenerCategoriasConEventos();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../stylesheets/dashboard/body.css?v=<?php echo time(); ?>">
    <script src="../stylesheets/js/category-slider.js?v=<?php echo time(); ?>"></script>
</head>

<body>
    <header>
        <?php include __DIR__ . '/components/navbar.php'; ?>
    </header>
    
    <div class="categories-wrapper">
        <button class="scroll-btn scroll-left" id="scrollLeft" aria-label="Desplazar a la izquierda">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        
        <div class="categories-container" id="categoriesContainer">
            <?php foreach ($categorias as $cat): ?>
                <div class="category-item" onclick="toggleCategory('cat-<?php echo $cat->id; ?>')">
                    <h3><?php echo htmlspecialchars($cat->desc); ?></h3>
                    <p><?php echo count($cat->eventos); ?> eventos</p>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button class="scroll-btn scroll-right" id="scrollRight" aria-label="Desplazar a la derecha">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>
    
    <!-- Indicador visual de scroll -->
    <div class="scroll-indicator" id="scrollIndicator"></div>
    
    <div class="events-section">
        <?php foreach ($categorias as $cat): ?>            
            <div class="category-events" id="cat-<?php echo $cat->id; ?>">
                <h3>Categoría: <?php echo htmlspecialchars($cat->desc); ?></h3>                <?php if (count($cat->eventos) > 0): ?>
                    <ul>
                    <?php foreach ($cat->eventos as $ev): ?>
                        <li>
                            <div class="evento-info">
                                <strong><?php echo htmlspecialchars($ev->titulo); ?></strong>
                                <div class="evento-detalles">
                                    <span><?php echo htmlspecialchars($ev->fecha); ?></span>
                                    <span><?php echo htmlspecialchars($ev->lugar); ?></span>
                                </div>
                                <?php if(!empty($ev->desc)): ?>
                                    <p class="evento-descripcion"><?php echo htmlspecialchars($ev->desc); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if (strtotime($ev->fecha) > time() && $esCliente): ?>
                                <form action="comprar_ticket.php" method="get">
                                    <input type="hidden" name="evento_id" value="<?php echo $ev->id; ?>">
                                    <button type="submit">Comprar tickets</button>
                                </form>
                            <?php elseif (strtotime($ev->fecha) <= time()): ?>
                                <div class="evento-finalizado">Evento finalizado</div>
                            <?php elseif (!$esCliente): ?>
                                <div class="evento-info-message">Inicia sesión como cliente para comprar</div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No hay eventos para esta categoría.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if ($esOrganizador): ?>
        <a href="../view/crear_evento.php" class="create-event-btn">Crear nuevo evento</a>
    <?php endif; ?>
</body>
</html>
