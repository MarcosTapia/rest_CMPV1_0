<?php
/**
 * Obtiene el ultimo id de las fallas
 */

require 'Fallas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $fallas = Fallas::getLastId();
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

