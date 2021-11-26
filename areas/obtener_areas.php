<?php
/**
 * Obtiene todas las areas de la base de datos
 */

require 'Areas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $areas = Areas::getAll();
    if ($areas) {
        $datos["estado"] = 1;
        $datos["areas"] = $areas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

