<?php
/**
 * Obtiene el registro del mantenimiento
 * su identificador "idFechaMantenimiento"
 */

require 'Turnos.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parametro1 = $_GET['idResponsable'];
    $parametro2 = $_GET['week'];
    $parametro3 = $_GET['idMaquina'];
    $parametro4 = $_GET['fecha1'];
    $parametro5 = $_GET['fecha2'];    
    $paros = Turnos::obtenerParosConsulta($parametro1,$parametro2,$parametro3,$parametro4,$parametro5);  
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
