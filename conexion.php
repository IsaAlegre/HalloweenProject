<?php
// Variable global para almacenar el objeto de conexión
$con = null;

function conectar()
{
    global $con;
    // --- Configura estos parámetros según tu instalación de WAMP/MySQL ---
    $host = "localhost";
    $user = "root";
    $password = "0405"; 
    $database = "halloween";
    
    $con = mysqli_connect($host, $user, $password, $database);
    
    /* comprobar la conexión */
    if (mysqli_connect_errno()) 
    {
        // Esto mostrará el error en pantalla si la conexión falla
        printf("Falló la conexión a MySQL: %s\n", mysqli_connect_error());
        exit();
    }
    else
    {
        // Establece la codificación de caracteres a UTF-8
        $con->set_charset("utf8");
        return true;
    }
}

function desconectar()
{
    global $con;
    if ($con) {
        mysqli_close($con);
    }
}
?>