<?php
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

// Obtener la calificación almacenada en la base de datos (ajusta esto según tu estructura de tabla)
$query = "SELECT calificacion FROM recetas WHERE idRecetas = 2"; // Reemplaza 1 por el ID de la receta correspondiente

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $calificacion = $row["calificacion"];

    // Devolver la calificación como respuesta al AJAX
    echo $calificacion;
} else {
    echo "0";
}

mysqli_close($conn);
?>

