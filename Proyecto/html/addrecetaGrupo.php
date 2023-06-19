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


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idReceta = $_GET['id'];
    
    // Realizar la inserción en la base de datos
    $query = "INSERT INTO registros (idReceta) VALUES ('$idReceta')";
    if (mysqli_query($conn, $query)) {
        echo "El ID de la receta $idReceta ha sido agregado al registro.";
    } else {
        echo "Error al agregar el ID de la receta al registro: " . mysqli_error($conn);
    }
} else {
    echo "ID de receta inválido.";
}


mysqli_close($conn);
?>
