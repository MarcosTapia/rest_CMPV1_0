<?php
/**
 * Obtiene los mensajes por fechas 
 */

require 'Util.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar peticion GET
    $parametro1 = $_GET['fIni'];
    $parametro2 = $_GET['fFin'];
    $mensajes = Util::obtieneMensajesPorFechas($parametro1,$parametro2);
    if ($mensajes) {
        $datos["estado"] = 1;
        $datos["mensajes"] = $mensajes;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
//        print json_encode(array(
//            "estado" => 2,
//            "mensaje" => $parametro1."-".$parametro2
//        ));
    }
}

