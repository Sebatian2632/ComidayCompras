<?php
include('connect.php');
session_start();

$correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : null;

// Recibir los datos de la consulta desde JavaScript
$no_porciones = isset($_POST['no_porciones']) ? $_POST['no_porciones'] : null;
$idReceta = isset($_POST['idReceta']) ? $_POST['idReceta'] : null;

$consultaP = "SELECT idplaneacion AS id FROM planeacion p JOIN usuarios u on (p.idplaneacion=u.planeacion_idplaneacion) WHERE correo = '$correo';";
$result = mysqli_query($conex, $consultaP);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];

// Realizar la consulta a la base de datos utilizando los datos recibidos
$query = "INSERT INTO recetas_has_planeacion (recetas_idRecetas, recetas_Usuarios_correo, planeacion_idplaneacion, no_porciones) VALUES ('$idReceta', '$correo', '$id', '$no_porciones');";

// Imprimir la consulta
echo "Consulta SQL: " . $query;

mysqli_query($conex,$query);

?>
