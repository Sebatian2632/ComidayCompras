<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recetasDB";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Obtener los valores actuales de la base de datos
$resultadonombre = mysqli_query($conn, "SELECT nombre FROM recetas WHERE idRecetas = 1");
$nombre = mysqli_fetch_assoc($resultadonombre)["nombre"];



// Recibir los nuevos valores del formulario
$nombre_nuevo = $_POST['nombre'];
$duracion_nuevo = $_POST['duracion'];
$porciones_nuevo = $_POST['duracion'];



// Actualizar la base de datos con los nuevos valores
mysqli_query($conn, "UPDATE usuarios SET nombre='$nombre_nuevo', email='$email_nuevo' WHERE id=$id");

echo "Los datos han sido actualizados correctamente";

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>






