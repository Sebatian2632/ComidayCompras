<?php
    
    //Conexión a la base de datos
    include 'connect.php';

    $data = json_decode(file_get_contents('php://input'), true);
    $accion = isset($data['accion']) ? $data['accion'] : '';

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
            actionReadPHP($conex);
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
        $data = json_decode(file_get_contents('php://input'), true);    //Parte para decodificar lo que recibimos del js
        /*$ingrediente = isset($data['nombre']) ? $data['nombre'] : '';   //Parte para validar que no este vacio
        $cantidad = isset($data['cantidad']) ? $data['cantidad'] : '';  
        $unidad_medida = isset($data['unidad_medida']) ? $data['unidad_medida'] : '';*/

        $ingrediente = $data['nombre'];   //Parte para validar que no este vacio
        $cantidad = $data['cantidad'];  
        $unidad_medida = $data['unidad_medida'];

        $email = isset($data['email']) ? $data['email'] : '';
        //Consulta del id en la base de datos
        $consultaid =  "SELECT idIngredientes FROM ingredientes WHERE nombre = '$ingrediente'";
        $resultadoid = mysqli_query($conex,$consultaid);
        if(mysqli_num_rows($resultadoid)==1)
        {
            $id = mysqli_fetch_assoc($resultadoid)['idIngredientes']-1; 
            //echo json_encode(['id' => $id]);       ->Parte para poder ver el id que estamos recogiendo
    
            //Consulta de la inserción a la base de datos
            $consultainsert = "INSERT INTO `usuario_has_ingredientes`(`usuario_correo`, `ingrediente_id`, `cantidad`, `unidad_medida`) VALUES ('$email','$id','$cantidad','$unidad_medida')";
            $resultadoinsert = mysqli_query($conex,$consultainsert);
                
            if($resultadoinsert)
            {
                echo json_encode(['Respuesta' => 1]);
            }
        }
        else
        {
            echo json_encode(['Respuesta' => 0]);
        }
    }
?>