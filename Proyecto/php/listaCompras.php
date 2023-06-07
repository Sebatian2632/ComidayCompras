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
            
            // Realizar una consulta para obtener el ID de planeación según el correo
            $QueryCorreo = "SELECT planeacion_idplaneacion FROM usuarios WHERE correo = '$correo'";
            $ResultadoCorreo = mysqli_query($conex, $QueryCorreo);
            
            // Verificar si se obtuvo algún resultado
            if ($ResultadoCorreo && mysqli_num_rows($ResultadoCorreo) > 0) {
                $fila = mysqli_fetch_assoc($ResultadoCorreo);
                $idPlaneacion = $fila['planeacion_idplaneacion'];
                
                // Consulta todas la recetas de planeación
                // Obtiene idReceta y porciones
                $QueryReadRecetas =    "SELECT idRecetas, porciones, no_porciones 
                                        FROM recetas JOIN recetas_has_planeacion 
                                        ON recetas.idRecetas = recetas_has_planeacion.recetas_idRecetas
                                        WHERE recetas_has_planeacion.planeacion_idplaneacion = '$idPlaneacion'";
                $ResultadoReadRecetas = mysqli_query($conex, $QueryReadRecetas);
                $numeroRegistrosRecetas = mysqli_num_rows($ResultadoReadRecetas);

                if ($numeroRegistrosRecetas > 0) {
                    $Respuesta['entregas'] = array();
                    while ($RenglonEntregaReceta = mysqli_fetch_assoc($ResultadoReadRecetas)){
                        $idReceta = $RenglonEntregaReceta['idRecetas'];
                        $porcionesOriginal = $RenglonEntregaReceta['porciones'];
                        $porcionesPedidas = $RenglonEntregaReceta['no_porciones'];

                        // Consulta los ingredientes de la receta
                        // recetas_has_ingredientes ---> Ingredientes_idIngredientes, cantidad, unidad_medida
                        // ingredientes ---> nombre
                        $QueryReadIngredientes = "SELECT Ingredientes_idIngredientes, cantidad, unidad_medida, nombre
                                                FROM recetas_has_ingredientes JOIN ingredientes 
                                                ON recetas_has_ingredientes.Ingredientes_idIngredientes = ingredientes.idIngredientes
                                                WHERE recetas_has_ingredientes.Recetas_idRecetas = '$idReceta'";
                        $ResultadoReadIngredientes = mysqli_query($conex, $QueryReadIngredientes);
                        $numeroRegistrosIngredientes = mysqli_num_rows($ResultadoReadIngredientes);

                        if ($numeroRegistrosIngredientes > 0) {
                            while ($RenglonEntregaIngredientes = mysqli_fetch_assoc($ResultadoReadIngredientes)){   // POR CADA INGREDIENTE
                                $idIngrediente = $RenglonEntregaIngredientes['Ingredientes_idIngredientes'];
                                $cantidadTemp = $RenglonEntregaIngredientes['cantidad'];
                                $unidad_medidaTemp = $RenglonEntregaIngredientes['unidad_medida'];
                                $nombreIngrediente = $RenglonEntregaIngredientes['nombre'];

                                $Entrega = array();

                                if($unidad_medidaTemp == "Pieza(s)"){                                               // SI SON PIEZAS...
                                    // Consulta los ingredientes disponibles del usuario
                                    // usuario_has_ingredientes ---> *
                                    $QueryReadIngredientesDisponibles = "SELECT * FROM usuario_has_ingredientes
                                                                        WHERE ingrediente_id = '".$idIngrediente."'
                                                                        AND usuario_correo =".$correo;
                                    $ResultadoReadIngredientesDisponibles = mysqli_query($conex, $QueryReadIngredientesDisponibles);
                                    if ($ResultadoReadIngredientesDisponibles && mysqli_num_rows($ResultadoReadIngredientesDisponibles) > 0) {
                                        $filaIngD = mysqli_fetch_assoc($ResultadoReadIngredientesDisponibles);
                                        $cantidadDisponible = $filaIngD['cantidad'];
                                        $unidad_medidaDisponibleTemp = $filaIngD['unidad_medida'];
                                    }else {
                                        $cantidadDisponible = 0;
                                        $unidad_medidaDisponibleTemp = 0;
                                    }
                                    
                                    // Hace el cálculo según las porciones que se dieron en la planeación, redondea al siguiente número entero
                                    $cantidadTotalIngrediente = ceil((($cantidadTemp / $porcionesOriginal) * $porcionesPedidas) - $cantidadDisponible);

                                    $Entrega['nombreIngrediente'] = $nombreIngrediente;
                                    $Entrega['cantidadTotalIngrediente'] = $cantidadTotalIngrediente;
                                    $Entrega['UnidadMedidaDefinitiva'] = $unidad_medidaTemp;
                                                                    
                                }else{
                                    $Entrega['nombreIngrediente'] = "Sabe";
                                    $Entrega['cantidadTotalIngrediente'] = 0;
                                    $Entrega['UnidadMedidaDefinitiva'] = "Kilogramo(s) o litro(s)";
                                }

                                $Respuesta['estado'] = 1;
                                $Respuesta['mensaje'] = "Los registros se listan correctamente";
                                
                                array_push($Respuesta['entregas'], $Entrega);   



                            }
                        }else{
                            $Respuesta['estado'] = 0;
                            $Respuesta['mensaje'] = "Lo siento, pero no hay registros para mostrar";
                        }
                    }
                }else{
                    $Respuesta['estado'] = 0;
                    $Respuesta['mensaje'] = "Lo siento, pero no hay registros para mostrar";
                }
            }else{
                $Respuesta['estado'] = 0;
                $Respuesta['mensaje'] = "Lo siento, pero no hay registros para mostrar";
            }
        }else{
            $Respuesta['estado'] = 0;
            $Respuesta['mensaje'] = "Lo siento, pero no hay registros para mostrar";
        }     

        // Antes de enviarla se tiene que filtrar, para que no vaya a salir Huevo 2 piezas, Huevo 8 piezas, Huevo 20 piezas
        // Solo se puede que "Huevo 30 piezas" y "Huevo 4 kg o L", entonces máximo puede repetirse 2 veces

        echo json_encode($Respuesta);
        mysqli_close($conex); 
    }
?>