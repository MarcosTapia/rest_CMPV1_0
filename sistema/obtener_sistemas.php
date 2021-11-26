<?php
/**
 * Obtiene todas los datos del sistema de la base de datos
 */

require 'Sistema.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petici�n GET
    $sistemas = Sistema::getAll();

    if ($sistemas) {

        $datos["estado"] = 1;
        $datos["sistemas"] = $sistemas;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

