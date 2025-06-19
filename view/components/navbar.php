<link rel="stylesheet" href="../stylesheets/components/navbar.css?v=<?php echo time(); ?>">
<script src="../stylesheets/js/navbar.js"></script>

<nav class="navbar">
    <div class="navbar-content">
        <div class="top-bar">
            <a href="dashboard.php"><img src="../stylesheets/images/icon.svg" alt="Ticketera Logo" class="logo-img" /></a>
            <div class="search-container">
                <form action="dashboard.php" method="get">
                    <span class="search-icon" aria-label="Buscar"></span>
                    <input type="text" name="buscar_evento" placeholder="Buscar eventos..." value="<?php echo isset($_GET['buscar_evento']) ? htmlspecialchars($_GET['buscar_evento']) : ''; ?>">
                </form>
                <button class="hamburger-menu" aria-label="Menu">
                    <span class="hamburger-icon"></span>
                </button>
            </div>
        </div>        <div class="actions">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span class="welcome-message">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>!</span>
                <a href="perfil_cliente.php" class="profile-link">
                    <img src="../stylesheets/images/profile.svg" alt="Perfil" class="profile-icon">
                    Mi Perfil
                </a>
                <a href="dashboard.php">Mis tickets</a>
            <?php else: ?>
                <a href="login.php">Iniciar sesión</a>
                <a href="registro.php">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
