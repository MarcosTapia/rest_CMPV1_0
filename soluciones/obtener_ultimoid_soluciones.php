<?php
/**
 * Obtiene el ultimo id de las fallas
 */

require 'Soluciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $soluciones = Soluciones::getLastId();
    if ($soluciones) {
        $datos["estado"] = 1;
        $datos["soluciones"] = $soluciones;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

