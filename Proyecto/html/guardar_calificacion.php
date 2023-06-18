<?php
// Obtén el ID de la receta y la calificación enviados por el formulario
$idReceta = $_POST["idReceta"];
$calificacion = $_POST["calificacion"];

// Realiza la inserción o actualización en la base de datos (ajusta esto según tu estructura de tabla)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recetasDB";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si ya existe una calificación para la receta actual
$sql = "SELECT * FROM recetas WHERE idReceta = $idReceta";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Actualiza la calificación existente
    $sql = "UPDATE recetas SET calificacion = $calificacion WHERE idReceta = $idReceta";
    $conn->query($sql);
} else {
    // Inserta una nueva calificación
    $sql = "INSERT INTO recetas (idReceta, calificacion) VALUES ($idReceta, $calificacion)";
    $conn->query($sql);
}

// Cierra la conexión
$conn->close();


exit();
?>
