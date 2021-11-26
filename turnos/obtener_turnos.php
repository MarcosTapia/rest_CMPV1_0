<?php
/**
 * Obtiene todas los turnos de la base de datos
 */

require 'Turnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $turnos = Turnos::getAll();
    if ($turnos) {
        $datos["estado"] = 1;
        $datos["turnos"] = $turnos;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

