<?PHP

$usuario=$_POST['correo'];
$contrasena=$_POST['clave'];


session_start();
$_SESSION['correo']=$usuario;

include('connect.php');


$consulta="SELECT * FROM usuarios WHERE correo= '$usuario' and clave ='$contrasena'";
$resultado=mysqli_query($conex,$consulta);
$datos=mysqli_fetch_array($resultado);
$filas=mysqli_num_rows($resultado);


if($filas)
{
    header("location:../html/readReceta.php");
}
else{
    echo "<script>
        alert('Nombre de usuario o contraseña incorrectos');
        </script>";
        include("../html/index.html");
}


mysqli_free_result($resultado);
mysqli_close($conex);
?>
