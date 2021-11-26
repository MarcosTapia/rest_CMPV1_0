<?php
/**
 * Obtiene el registro del mantenimiento
 * su identificador "idFechaMantenimiento"
 */

require 'Mantenimiento.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parametro1 = $_GET['idUsuario'];
    $parametro2 = $_GET['week'];
    $mantenimientos = Mantenimiento::getByWeekUser($parametro1,$parametro2);  
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
