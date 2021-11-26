<?php
/**
 * Obtiene todos los movimientos de la base de datos
 */

require 'InventarioToolcrib.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $movimientos = InventarioToolcrib::getAllMovs();
    if ($movimientos) {
        $datos["estado"] = 1;
        $datos["movimientos"] = $movimientos;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

