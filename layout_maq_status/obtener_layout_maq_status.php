<?php
/**
 * Obtiene todas las ubicaciones de las máquinas de la base de datos
 */

require 'Layoutmaqstatus.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $layoutmaqstatus = Layoutmaqstatus::getAll();
    if ($layoutmaqstatus) {
        $datos["estado"] = 1;
        $datos["layoutmaqstatus"] = $layoutmaqstatus;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

