<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hashear la contraseña
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    conectar();
    global $con;
    
    // Verificar si el usuario existe
    $stmt = $con->prepare("SELECT id FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        desconectar();
        header('Location: registro.php?error=usuario_existe');
        exit();
    }
    
    // Insertar nuevo usuario
    $stmt_insert = $con->prepare("INSERT INTO usuarios (nombre, clave) VALUES (?, ?)");
    $stmt_insert->bind_param("ss", $username, $password_hash);
    
    if ($stmt_insert->execute()) {
        desconectar();
        header('Location: login.php?registro=exitoso');
        exit();
    } else {
        desconectar();
        header('Location: registro.php?error=registro_fallido');
        exit();
    }
} else {
    header('Location: registro.php');
    exit();
}
?>