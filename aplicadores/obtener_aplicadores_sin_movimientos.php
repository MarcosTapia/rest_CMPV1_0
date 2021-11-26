<?php
/**
 * Obtiene todas las areas de la base de datos
 */

require 'Aplicadores.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $aplicadores = Aplicadores::getAllWithOutMovs();
    if ($aplicadores) {
        $datos["estado"] = 1;
        $datos["aplicadores"] = $aplicadores;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

