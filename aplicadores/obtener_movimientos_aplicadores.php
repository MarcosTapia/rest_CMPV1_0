<?php
/**
 * Obtiene todas las areas de la base de datos
 */

require 'Aplicadores.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $movimientos_aplicadores = Aplicadores::getAllMovsAplicadores();
    if ($movimientos_aplicadores) {
        $datos["estado"] = 1;
        $datos["movimientos_aplicadores"] = $movimientos_aplicadores;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

