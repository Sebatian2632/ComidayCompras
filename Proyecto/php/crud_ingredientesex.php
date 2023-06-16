<?php
    
    //Conexión a la base de datos
    include 'connect.php';
    $Respuesta = array();
    $accion    = $_POST['accion'];

    switch ($accion) {
        case 'create':
            actionCreatePHP($conex);
            break;
        case 'update':
            actionUpdatePHP($conex);
            break;
        case 'delete':
            actionDeletePHP($conex);
            break;
        case 'read':
            actionRead($conex);
            break;
        case 'read_id':
            actionReadByIdPHP($conex);
            break;
        default:
            # code...
            break;
    }

    function actionCreatePHP($conex)
    {
        //Recuperación de los datos
        $nombre = $_POST['nom'];
        $cantidad = $_POST['cant'];
        $unidad_medida = $_POST['unid'];
        $email = $_POST['correo'];

        //Consulta del id en la base de datos
        $consultaid =  "SELECT idIngredientes FROM ingredientes WHERE nombre = '$nombre'";
        $resultadoid = mysqli_query($conex,$consultaid);
        if(mysqli_num_rows($resultadoid)==1)
        {
            $id = mysqli_fetch_assoc($resultadoid)['idIngredientes']; 
    
            //Consulta de la inserción a la base de datos
            $consultainsert = "INSERT INTO `usuario_has_ingredientes`(`usuario_correo`, `ingrediente_id`, `cantidad`, `unidad_medida`) VALUES ('$email','$id','$cantidad','$unidad_medida')";
                
            if(mysqli_query($conex,$consultainsert))
            {
                $Respuesta['id'] = mysqli_insert_id($conex); 
                $Respuesta['estado'] = 1;
                $Respuesta['mensaje'] = "Ingrediente guardado con exito.";
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
        $consultarea = "SELECT * FROM usuario_has_ingredientes WHERE usuario_correo = '$email'";
        $rconsulta = mysqli_query($conex,$consultarea);
        $numeroRegistros = mysqli_num_rows($rconsulta);

        if(mysqli_num_rows($rconsulta) > 0)
        {
            $Respuesta['estado'] = 1;
            $Respuesta['entregas'] = array();
            
            while ($RenglonEntrega = mysqli_fetch_assoc($rconsulta)) {
                $Entrega = array();
                $Entrega['idDisponibles'] = $RenglonEntrega['idDisponibles'];
                $Entrega['usuario_correo'] = $RenglonEntrega['usuario_correo'];
                $Entrega['cantidad'] = $RenglonEntrega['cantidad'];
                $Entrega['unidad_medida'] = $RenglonEntrega['unidad_medida'];
            
                $ingrediente_id = $RenglonEntrega['ingrediente_id'];
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
?>