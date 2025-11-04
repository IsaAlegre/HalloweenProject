<?php
include 'header.php'; 
?>

<section class="section">
    <h2>Registro de Usuario</h2>
    <?php 
    if (isset($_GET['error'])) {
        switch($_GET['error']) {
            case 'usuario_existe':
                echo '<p class="error">El nombre de usuario ya está en uso.</p>';
                break;
            case 'registro_fallido':
                echo '<p class="error">Error al registrar el usuario. Intente nuevamente.</p>';
                break;
        }
    }
    ?>
    <form action="procesar_registro.php" method="POST">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</section>

<?php include 'footer.php'; ?>