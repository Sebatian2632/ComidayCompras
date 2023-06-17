<?php
    
    //Conexión a la base de datos
    include 'connect.php';
    $Respuesta = array();
    $accion    = $_POST['accion'];

    switch ($accion) {
        case 'create':
            actionCreatePHP($conex);
            break;
        case 'delete':
            actionDeletePHP($conex);
            break;
        case 'read':
            actionRead($conex);
            break;
        case 'delete_all':
            actionDeleteAll($conex);
            break;
        default:
            # code...
            break;
    }

    function actionCreatePHP($conex)
    {
        //Recuperación de los datos
        $nombre = $_POST['nom'];
        $email = $_POST['correo'];

        //Consulta del id en la base de datos
        $consultaid =  "SELECT idIngredientes FROM ingredientes WHERE nombre = '$nombre'";
        $resultadoid = mysqli_query($conex,$consultaid);
        if(mysqli_num_rows($resultadoid)==1)
        {
            $id = mysqli_fetch_assoc($resultadoid)['idIngredientes']; 
    
            //Consulta de la inserción a la base de datos
            $consultainsert = "INSERT INTO `alergias`(`usuarios_correo`, `ingredientes_idIngredientes`) VALUES ('$email ','$id')";
                
            if(mysqli_query($conex,$consultainsert))
            {
                $Respuesta['id'] = mysqli_insert_id($conex); 
                $Respuesta['estado'] = 1;
                $Respuesta['mensaje'] = "Alergia guardada con exito.";
            }
        }
        else
        {
            $Respuesta['estado'] = 0;
            $Respuesta['mensaje'] = "Error al guardar el ingrediente, intentelo de nuevo.";
        }
        echo json_encode($Respuesta);
        mysqli_close($conex);
    }

    function actionRead($conex)
    {
        $email = $_POST['correo'];
        $consultarea = "SELECT * FROM alergias WHERE usuarios_correo = '$email'";
        $rconsulta = mysqli_query($conex,$consultarea);
        $numeroRegistros = mysqli_num_rows($rconsulta);

        if(mysqli_num_rows($rconsulta) > 0)
        {
            $Respuesta['estado'] = 1;
            $Respuesta['entregas'] = array();
            
            while ($RenglonEntrega = mysqli_fetch_assoc($rconsulta)) {
                $Entrega = array();
                $Entrega['idalergia'] = $RenglonEntrega['idalergia'];
                $Entrega['usuarios_correo'] = $RenglonEntrega['usuarios_correo'];
            
                $ingrediente_id = $RenglonEntrega['ingredientes_idIngredientes'];
                $consultaIngrediente = "SELECT nombre FROM ingredientes WHERE idIngredientes = '$ingrediente_id'";
                $rconsultaIngrediente = mysqli_query($conex, $consultaIngrediente);
                $RenglonIngrediente = mysqli_fetch_assoc($rconsultaIngrediente);
                $nombreIngrediente = $RenglonIngrediente['nombre'];
            
                $Entrega['nombre_ingrediente'] = $nombreIngrediente;
            
                array_push($Respuesta['entregas'], $Entrega);
            }            
        }
        else
        {
            $Respuesta['estado'] = 0;
            $Respuesta['mensaje'] = "Ocurrio un error desconocido";
        }
        echo json_encode($Respuesta);
        mysqli_close($conex);
    }

    function actionDeletePHP($conex)
    {
        $idDelete = $_POST['id'];

        $consulta = "DELETE FROM alergias WHERE idalergia = '$idDelete'";
        if(mysqli_query($conex, $consulta))
        {
            $Respuesta['estado'] = 1;
        }
        else
        {
            $Respuesta['estado'] = 0;
        }
        echo json_encode($Respuesta);
        mysqli_close($conex);
    }

    function actionDeleteAll($conex)
    {
        $email = $_POST['correo'];

        $consulta = "DELETE FROM alergias WHERE usuarios_correo = '$email'";
        if(mysqli_query($conex, $consulta))
        {
            $Respuesta['estado'] = 1;
        }
        else
        {
            $Respuesta['estado'] = 0;
        }
        echo json_encode($Respuesta);
        mysqli_close($conex);
    }

?>