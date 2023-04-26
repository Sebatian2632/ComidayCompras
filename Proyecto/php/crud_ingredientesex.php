<?php
        //Conexión a la base de datos
        include 'connect.php';
        //Recuperación de los datos
        $data = json_decode(file_get_contents('php://input'), true);    //Parte para decodificar lo que recibimos del js
        $ingrediente = isset($data['nombre']) ? $data['nombre'] : '';   //Parte para validar que no este vacio
        $cantidad = isset($data['cantidad']) ? $data['cantidad'] : '';  
        $unidad_medida = isset($data['unidad_medida']) ? $data['unidad_medida'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        //Consulta del id en la base de datos
        $consultaid =  "SELECT idIngredientes FROM ingredientes WHERE nombre = '$ingrediente'";
        $resultadoid = mysqli_query($conex,$consultaid);
        $id = mysqli_fetch_assoc($resultadoid)['idIngredientes']-1; 
        //echo json_encode(['id' => $id]);       ->Parte para poder ver el id que estamos recogiendo

        if($ingrediente === '' || $cantidad === '' || $unidad_medida === '')
        {
            echo json_encode(['message' => 'Llena todos los campos']);
        }
        else
        {
            //Consulta de la inserción a la base de datos
            $consultainsert = "INSERT INTO `usuario_has_ingredientes`(`usuario_correo`, `ingrediente_id`, `cantidad`, `unidad_medida`) VALUES ('$email','$id','$cantidad','$unidad_medida')";
            $resultadoinsert = mysqli_query($conex,$consultainsert);
            
            if($resultadoinsert)
            {
                echo json_encode(['message' => 'Datos guardados exitosamente']);
            }
            else
            {
                echo json_encode(['message' => 'Error al guardar los datos']);
            }
        }
?>