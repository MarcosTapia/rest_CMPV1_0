<?php
/**
 * Obtiene todas los datos de la empresa de la base de datos
 */

require 'DatosEmpresa.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petici�n GET
    $datosEmpresas = DatosEmpresa::getAll();

    if ($datosEmpresas) {

        $datos["estado"] = 1;
        $datos["datosEmpresas"] = $datosEmpresas;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

