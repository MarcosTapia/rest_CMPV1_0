<?php
/**
 * Obtiene todas los mantenimientos de la base de datos
 */

require 'Mantenimiento.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $mantenimientos = Mantenimiento::getAll();
    if ($mantenimientos) {
        $datos["estado"] = 1;
        $datos["mantenimientos"] = $mantenimientos;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

