<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recetasDB";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


// Verificar si se ha eliminado el registro

$eliminareceta = mysqli_query($conn, "DELETE FROM usuario_has_grupo WHERE id_grupo = 1");
// Redireccionar al index
header("Location: \\ComidayCompras/Proyecto/html/misGrupos.html");
exit(); // Asegura que el script se detenga después de redirigir

if ($conn->query($eliminareceta) === TRUE) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error al eliminar el registro: " . $conn->error;
}



mysqli_close($conn);
?>
