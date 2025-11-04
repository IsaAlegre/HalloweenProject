<?php
// 1. Iniciar la sesión para obtener el ID del usuario
session_start();

// 2. Incluir la conexión
include 'conexion.php';

// 3. Verificación de Seguridad: ¿Está logueado?
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php'); // Si no, al login
    exit();
}

// 4. Verificar que se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 5. Obtener los IDs
    $id_usuario = $_SESSION['id_usuario'];
    $id_disfraz = $_POST['id_disfraz'];

    // 6. Conectar a la BD
    conectar();
    global $con;

    // 7. --- Verificación de Voto Duplicado ---
    $stmt_check = $con->prepare("SELECT id FROM votos WHERE id_usuario = ? AND id_disfraz = ?");
    $stmt_check->bind_param("ii", $id_usuario, $id_disfraz);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // 8. El usuario ya votó
        $stmt_check->close();
        desconectar();
        header('Location: index.php?error=yavoto');
        exit();
    }
    $stmt_check->close();


    // 9. --- Iniciar Transacción ---
    // (Para asegurar que ambas consultas funcionen)
    $con->begin_transaction();

    try {
        // 10. Paso A: Registrar el voto en la tabla 'votos'
        $stmt_insert = $con->prepare("INSERT INTO votos (id_usuario, id_disfraz) VALUES (?, ?)");
        $stmt_insert->bind_param("ii", $id_usuario, $id_disfraz);
        $stmt_insert->execute();

        // 11. Paso B: Actualizar el contador en la tabla 'disfraces'
        $stmt_update = $con->prepare("UPDATE disfraces SET votos = votos + 1 WHERE id = ?");
        $stmt_update->bind_param("i", $id_disfraz);
        $stmt_update->execute();

        // 12. Si ambos pasos funcionaron, confirmar la transacción
        $con->commit();

        $stmt_insert->close();
        $stmt_update->close();
        desconectar();

        // 13. Redirigir con éxito
        header('Location: index.php?exito=voto');
        exit();

    } catch (Exception $e) {
        // 14. Si algo falló, revertir la transacción
        $con->rollback();
        desconectar();
        
        // 15. Redirigir con error
        header('Location: index.php?error=db');
        exit();
    }

} else {
    // Si acceden directamente al archivo
    header('Location: index.php');
    exit();
}
?>