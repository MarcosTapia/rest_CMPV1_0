<?php
/**
 * Obtiene todas las areas de la base de datos
 */

require 'Fallasnotificaciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $fallasnotificaciones = Fallasnotificaciones::getAll();
    if ($fallasnotificaciones) {
        $datos["estado"] = 1;
        $datos["fallasnotificaciones"] = $fallasnotificaciones;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

