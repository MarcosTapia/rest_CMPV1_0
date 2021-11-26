<?php
/**
 * Obtiene todas las actividades de la base de datos
 */

require 'Actividades.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $actividades = Actividades::getAll();
    if ($actividades) {
        $datos["estado"] = 1;
        $datos["actividades"] = $actividades;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

