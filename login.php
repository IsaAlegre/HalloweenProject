<?php
include 'header.php'; ?>

<section class="section">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error">Usuario o contraseña incorrectos</p>
    <?php endif; ?>
    <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
        <p class="success">Registro exitoso. Por favor inicia sesión.</p>
    <?php endif; ?>
    <form action="procesar_login.php" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
</section>

<?php include 'footer.php'; ?>