<?php
/**
 * Obtiene todos las alertas de la base de datos
 */

require 'InventarioToolcrib.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $alertas = InventarioToolcrib::getAllAlerts();
    if ($alertas) {
        $datos["estado"] = 1;
        $datos["alertas"] = $alertas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

