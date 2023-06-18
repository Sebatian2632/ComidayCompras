<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recetasDB";

if (isset($_GET["idReceta"])) {
    $idReceta = $_GET["idReceta"];
    // Resto del código para eliminar el registro usando el valor de $idReceta
}else {
	echo "No se recibió el ID de la receta.";
  }

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


echo "Entra";

// Verificar si se ha eliminado el registro

$eliminareceta = mysqli_query($conn, "DELETE FROM recetas WHERE idRecetas = $idReceta");
// Redireccionar al index
header("Location: \\ComidayCompras/Proyecto/html/misRecetas.html");
exit(); // Asegura que el script se detenga después de redirigir

if ($conn->query($eliminareceta) === TRUE) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error al eliminar el registro: " . $conn->error;
}



mysqli_close($conn);
?>
