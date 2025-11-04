<?php 
include 'header.php'; 

// Verificación de Seguridad (que el usuario esté logueado)
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario']!= 1) {
    header('Location: index.php');
    exit();
}

?>

<section id="admin" class="section">
    <h2>Panel de Administración</h2>

    <form action="procesar_disfraz.php" method="POST" enctype="multipart/form-data">
        
        <label for="nombre">Nombre del Disfraz:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="descripcion">Descripción del Disfraz:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        
        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>

        <button type="submit">Agregar Disfraz</button>
    </form>
</section>

<?php include 'footer.php'; ?>