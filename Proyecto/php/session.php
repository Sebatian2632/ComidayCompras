<?php
    //Este documento funciona para saber si existe una session o es nula
    session_start();
    $correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : null;
    echo json_encode(array('correo' => $correo));
?>
