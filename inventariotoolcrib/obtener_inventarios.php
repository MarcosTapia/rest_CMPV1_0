<?php
/**
 * Obtiene todas las partes del inventario de la base de datos
 */

require 'InventarioToolcrib.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $inventarios = InventarioToolcrib::getAll();
    if ($inventarios) {
        $datos["estado"] = 1;
        $datos["inventarios"] = $inventarios;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

