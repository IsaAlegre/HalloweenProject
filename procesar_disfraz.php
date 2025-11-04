<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    conectar();
    global $con;
    
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $foto = $_FILES['foto']['name'];
    $foto_blob = file_get_contents($_FILES['foto']['tmp_name']);
    
    $query = "INSERT INTO disfraces (nombre, descripcion, votos, foto, foto_blob) VALUES (?, ?, 0, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $descripcion, $foto, $foto_blob);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['mensaje'] = "Disfraz agregado exitosamente";
    } else {
        $_SESSION['mensaje'] = "Error al agregar el disfraz";
    }
    
    desconectar();
    header('Location: admin.php');
}