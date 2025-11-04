<?php
include 'header.php'; // Incluye el encabezado y el menú
include 'conexion.php'; // Incluye tu función de conexión

conectar(); // Abre la conexión
global $con; // Hace la variable $con disponible

?>
    <section id="disfraces-list" class="section">
        <h2>Lista de Disfraces</h2>
        
        <?php
        // 1. Consultar los disfraces
        $sql = "SELECT  id, nombre, descripcion, votos, foto_blob  FROM disfraces WHERE eliminado = 0 ORDER BY votos DESC";
        $resultado = mysqli_query($con, $sql);

        // 2. Recorrer y mostrar cada disfraz
        while ($disfraz = mysqli_fetch_assoc($resultado)) 
        {
            // 3. Verificar si el usuario ya votó por este disfraz
            $ya_voto = false;
            if (isset($_SESSION['id_usuario'])) {
                $stmt_check = $con->prepare("SELECT id FROM votos WHERE id_usuario = ? AND id_disfraz = ?");
                $stmt_check->bind_param("ii", $_SESSION['id_usuario'], $disfraz['id']);
                $stmt_check->execute();
                $stmt_check->store_result();
                $ya_voto = $stmt_check->num_rows > 0;
                $stmt_check->close();
            }

        ?>
            <div class="disfraz">
                <h2><?php echo htmlspecialchars($disfraz['nombre']); ?></h2>
                <p><?php echo htmlspecialchars($disfraz['descripcion']); ?></p>
                
                <p><img src="data:image/jpeg;base64,<?php echo base64_encode($disfraz['foto_blob']); ?>" width="100%"></p>
                <p><strong>Votos: <?php echo $disfraz['votos']; ?></strong></p>

                <?php
                // 3. Lógica del botón Votar
                if (isset($_SESSION['id_usuario'])) {
                    if ($ya_voto) {
                        echo '<p class="info">Ya has votado por este disfraz.</p>';
                    } else {
                    // Si el usuario está logueado, muestra el form de votar
                ?>
                    <form action="votar.php" method="POST">
                        <input type="hidden" name="id_disfraz" value="<?php echo $disfraz['id']; ?>">
                        <button type="submit" class="votar">Votar</button>
                    </form>
                <?php
                    }
                } else {
                    // Si no, pide que inicie sesión
                    echo '<p><a href="login.php">Inicia sesión para votar</a></p>';
                }
                ?>
            </div>
            <hr>
        <?php
        } // Fin del bucle while
        ?>
        
    </section>

<?php
desconectar(); // Cierra la conexión
include 'footer.php'; // Incluye el pie de página
?>