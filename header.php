<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Concurso de disfraces de Halloween</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Ver Disfraces</a></li>
            <?php if (!isset($_SESSION['id_usuario'])): ?>
                <li><a href="registro.php">Registro</a></li>
                <li><a href="login.php">Iniciar Sesión</a></li>
            <?php else: ?>
                <li><a href="logout.php">Cerrar Sesión</a></li>
                <?php if ($_SESSION['id_usuario'] == 1): ?>
                    <li><a href="admin.php">Panel de Administración</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </nav>
    <header>
        <h1>Concurso de disfraces de Halloween</h1>
    </header>
    <main>