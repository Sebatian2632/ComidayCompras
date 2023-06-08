<?php
    //Conexión a la base de datos
    include 'connect.php';
    $Respuesta = array();
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'read':
            actionReadPHP($conex);
            break;
        default:
            # code...
            break;
    }

    function actionReadPHP($conex) {
        // Consultar por el correo el id_planeacion
        if (isset($_POST['correo'])) {
            $correo = $_POST['correo'];
            
            // Realiza consulta para sacar la lista de ingredientes que se necesitan para hacer todas lasrecetas con las porciones planeadas
            // Ya saca de cada ingrediente cuanto ocupa y lo pone por unidad de medida, ya suma.
            $QueryIngredientesPedidos = "SELECT rhi.Ingredientes_idIngredientes AS idIngredientePedido, 
                                        CASE WHEN COUNT(*) > 1 THEN SUM(((rhi.cantidad / r.porciones ) * rhp.no_porciones)) 
                                        ELSE ((rhi.cantidad / r.porciones ) * rhp.no_porciones) END AS cantidadPedida, 
                                        rhi.unidad_medida AS unidadMedidaPedida, i.nombre AS nombreIngredientePedido
                                        FROM recetas_has_ingredientes AS rhi
                                        JOIN ingredientes AS i ON rhi.Ingredientes_idIngredientes = i.idIngredientes
                                        JOIN recetas_has_planeacion AS rhp ON rhi.Recetas_idRecetas = rhp.recetas_idRecetas
                                        JOIN recetas AS r ON rhi.Recetas_idRecetas = r.idRecetas
                                        WHERE rhi.Recetas_idRecetas IN (
                                            SELECT r.idRecetas
                                            FROM recetas AS r
                                            JOIN recetas_has_planeacion AS rhp ON r.idRecetas = rhp.recetas_idRecetas
                                            WHERE rhp.planeacion_idplaneacion = (
                                                SELECT u.planeacion_idplaneacion
                                                FROM usuarios AS u
                                                WHERE u.correo = '".$correo."'
                                            )
                                        )
                                        GROUP BY rhi.Ingredientes_idIngredientes, rhi.unidad_medida, i.nombre";
            
            // Guarda el resultado de la consulta
            $ResultadoIngredientesPedidos = mysqli_query($conex, $QueryIngredientesPedidos);
            $numeroRegistros = mysqli_num_rows($ResultadoIngredientesPedidos);

            if ($numeroRegistros > 0) {
                $Respuesta['entregas'] = array();
            
                while ($RenglonEntrega = mysqli_fetch_assoc($ResultadoIngredientesPedidos)) {
                    $idIngredientePedido = $RenglonEntrega['idIngredientePedido'];
                    $cantidadPedida = $RenglonEntrega['cantidadPedida'];
                    $unidadMedida = $RenglonEntrega['unidadMedidaPedida'];
                    $nombreIngrediente = $RenglonEntrega['nombreIngredientePedido'];

                    if($unidadMedida === "Pieza(s)"){
                        // Si son piezas, como no necesita conversión, consulta si hay ingredientes disponibles
                        $QueryReadIngredientesDisponibles = "SELECT * FROM usuario_has_ingredientes
                                                            WHERE ingrediente_id = '".$idIngredientePedido."'
                                                            AND unidad_medida = 'Pieza(s)'
                                                            AND usuario_correo = '".$correo."'";

                        $ResultadoReadIngredientesDisponibles = mysqli_query($conex, $QueryReadIngredientesDisponibles);
                        if($ResultadoReadIngredientesDisponibles && mysqli_num_rows($ResultadoReadIngredientesDisponibles) > 0) {
                            $filaIngD = mysqli_fetch_assoc($ResultadoReadIngredientesDisponibles);
                            $cantidadDisponible = $filaIngD['cantidad'];

                            $cantidadTotalIngrediente = ceil($cantidadPedida - $cantidadDisponible);
                        }else{
                            $cantidadTotalIngrediente = ceil($cantidadPedida);
                        }

                        $Entrega = array();
                        $Entrega['nombreIngrediente'] = $nombreIngrediente;
                        $Entrega['cantidadTotalIngrediente']= $cantidadTotalIngrediente;
                        $Entrega['unidadMedida'] = $unidadMedida;
                        
                    }else{
                        $Entrega = array();
                        $Entrega['nombreIngrediente'] = $nombreIngrediente;
                        $Entrega['cantidadTotalIngrediente']= $cantidadPedida;
                        $Entrega['unidadMedida'] = $unidadMedida;
                    }

                    $Respuesta['estado'] = 1;
                    $Respuesta['mensaje'] = "Los registros se listan correctamente";

                    array_push($Respuesta['entregas'], $Entrega);
                }
            }else{
                $Respuesta['estado'] = 0;
                $Respuesta['mensaje'] = "Ocurrio un error desconocido";
            }
        }else{
            $Respuesta['estado'] = 0;
            $Respuesta['mensaje'] = "Ocurrio un error desconocido";
        }

        echo json_encode($Respuesta);
        mysqli_close($conex); 
    }
?>