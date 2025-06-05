<nav class="navbar">
    <span class="logo">Ticketera</span>
    <form action="dashboard.php" method="get">
        <input type="text" name="buscar_evento" placeholder="Buscar eventos..." value="<?php echo isset($_GET['buscar_evento']) ? htmlspecialchars($_GET['buscar_evento']) : ''; ?>">
        <button type="submit">Buscar</button>
    </form>
</nav>
