<?php
/**
 * Obtiene todas las fallas de la base de datos
 */

require 'Fallas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $fallas = Fallas::getAll();
    if ($fallas) {
        $datos["estado"] = 1;
        $datos["fallas"] = $fallas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

