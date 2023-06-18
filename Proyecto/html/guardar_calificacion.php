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


// Obtén el valor de la calificación enviado por AJAX
$rating = $_POST["rating"];

// Actualiza el valor de la calificación en la base de datos (ajusta esto según tu estructura de tabla)
$query = "UPDATE recetas SET calificacion = '$rating' WHERE idRecetas = 2"; // Reemplaza 1 por el ID de la receta correspondiente

if (mysqli_query($conn, $query)) {
    // Devuelve el rating actualizado como respuesta al AJAX
    echo $rating;
} else {
    echo "Error al guardar la calificación en la base de datos: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
