<?php
/**
 * Obtiene todas las ventas de la base de datos
 */

require 'Util.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
    $mensajes = Util::obtenerMensajes();
    if ($mensajes) {
        $datos["estado"] = 1;
        $datos["mensajes"] = $mensajes;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

