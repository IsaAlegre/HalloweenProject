<?php
// 1. ¡INICIAR LA SESIÓN ES LO PRIMERO!
// Esto es necesario para poder crear las variables $_SESSION
session_start(); 

// 2. Incluir la conexión
include 'conexion.php';

// 3. Verificar que los datos lleguen por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 5. Conectar a la BD
    conectar();
    global $con;

    // 6. Buscar al usuario en la BD
    $stmt = $con->prepare("SELECT id, nombre, clave FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        // Usuario encontrado, ahora verificar la contraseña
        $usuario = $resultado->fetch_assoc();
        
        // 7. --- ¡SEGURIDAD IMPORTANTE! ---
        // Verificar la contraseña hasheada
        if (password_verify($password, $usuario['clave'])) {
            
            // 8. ¡Contraseña correcta! Iniciar la sesión
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nombre_usuario'] = $usuario['nombre'];
            // (Podrías guardar un rol de admin aquí si lo tuvieras)
            
            // 9. Redirigir a la página principal
            header('Location: index.php');
            exit();

        } else {
            // Contraseña incorrecta
            header('Location: login.php?error=1');
            exit();
        }

    } else {
        // Usuario no encontrado
        header('Location: login.php?error=1');
        exit();
    }

    $stmt->close();
    desconectar();

} else {
    // Si alguien intenta acceder a este archivo directamente
    header('Location: login.php');
    exit();
}
?>