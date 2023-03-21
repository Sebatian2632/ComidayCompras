<?PHP

$usuario=$_POST['correo'];
$contrasena=$_POST['clave'];


session_start();
$_SESSION['correo']=$usuario;

include('connect.php');



$consulta="SELECT * FROM usuario WHERE correo= '$usuario' and clave ='$contrasena'";
$resultado=mysqli_query($conex,$consulta);
$datos=mysqli_fetch_array($resultado);
$filas=mysqli_num_rows($resultado);


mysqli_free_result($resultado);
mysqli_close($conex);
?>
