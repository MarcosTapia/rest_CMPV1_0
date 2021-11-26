<?php
/**
 * Obtiene el registro del mantenimiento
 * su identificador "idFechaMantenimiento"
 */

require 'Mantenimiento.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parametrosConsulta = $_GET['parametrosConsulta'];
    $mantenimientos = Mantenimiento::getQueryPersonalized($parametrosConsulta);  
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
