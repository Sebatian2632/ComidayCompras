<?php
include('connect.php');

$usuario=$_POST['usuario'];
$correo=$_POST['correo'];
$contrasena=$_POST['clave'];

$query = "INSERT INTO usuarios(correo,clave,nombre) VALUES ('$correo','$contrasena','$usuario')";
$resultado = mysqli_query($conex,$query);

if($resultado)
{
    echo '
    <script>
        alert("Usuario registrado exitosamente");
    </script>
    ';
    include("../html/index.html");
}
?>