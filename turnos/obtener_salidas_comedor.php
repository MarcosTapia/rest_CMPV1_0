<?php
/**
 * Obtiene todas los turnos de la base de datos
 */

require 'Turnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $salidas = Turnos::getAllSalidasComedor();
    if ($salidas) {
        $datos["estado"] = 1;
        $datos["salidas"] = $salidas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

