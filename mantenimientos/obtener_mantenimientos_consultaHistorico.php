<?php
/**
 * Obtiene el registro del mantenimiento
 * su identificador "idFechaMantenimiento"
 */

require 'Mantenimiento.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parametro1 = $_GET['idResponsable'];
    $parametro2 = $_GET['week'];
    $parametro3 = $_GET['idMaquina'];
    $parametro4 = $_GET['tabla'];
    $mantenimientos = Mantenimiento::obtenerMantenimientosConsultaHistorico($parametro1,$parametro2,$parametro3,$parametro4);
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
