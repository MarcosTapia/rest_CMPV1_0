<?php
/**
 * Obtiene todas los proveedores de la base de datos
 */

require 'Proveedores.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $proveedores = Proveedores::getAll();
    if ($proveedores) {
        $datos["estado"] = 1;
        $datos["proveedores"] = $proveedores;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

