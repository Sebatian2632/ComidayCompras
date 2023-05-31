function actionCreate() { 
    alert("Verificación 1");
    session_start();
    $_SESSION['correo']=$usuario;
    
    include('connect.php');

    
}