<?php
/**
 * Obtiene el registro de los paros
 */

require 'Turnos.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parametro1 = $_GET['fecha1'];
    $parametro2 = $_GET['fecha2'];    
    $paros = Turnos::obtenerParosConsultaGraficos($parametro1,$parametro2);  
    if ($paros) {
        $datos["estado"] = 1;
        $datos["paros"] = $paros;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}
