<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recetasDB";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    // Obtener la sentencia SQL enviada por el cliente
    $sql = $_POST['sql'];

    // Ejecutar la sentencia SQL en la base de datos
    $conn->query($sql);

    // Enviar respuesta al cliente (mensaje de confirmación)
    echo "Ingrediente insertado en la base de datos.";

    // Cerrar conexión a la base de datos
    $conn->close();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
