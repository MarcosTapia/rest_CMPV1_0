<?php
/**
 * Obtiene fecha de servidor de la base de datos
 */

require 'Util.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
    $fechaServidor = Util::obtenerFechaServidor();
    if ($fechaServidor) {
        $datos["estado"] = 1;
        $datos["fechaServidor"] = $fechaServidor;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

