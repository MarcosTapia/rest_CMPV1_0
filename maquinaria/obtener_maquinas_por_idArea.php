<?php
/**
 * Obtiene el registro del mantenimiento
 * por idMaquina
 */

require 'Maquinas.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parametro1 = $_GET['idArea'];
    $maquinas = Maquinas::getByidArea($parametro1);  
    if ($maquinas) {
        $datos["estado"] = 1;
        $datos["maquinas"] = $maquinas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}