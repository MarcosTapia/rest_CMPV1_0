<?php
/**
 * Obtiene todas las maquinas de la base de datos
 */

require 'Maquinas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$maquinas = Maquinas::getAllActivesWithActivities();
    if ($maquinas) {
        $datos["estado"] = 1;
        $datos["maquinas"] = $maquinas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

