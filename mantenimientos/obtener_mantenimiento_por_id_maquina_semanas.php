<?php
/**
 * Obtiene el registro del mantenimiento
 * por idMaquina
 */

require 'Mantenimiento.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parametro1 = $_GET['idMaquina'];
    $parametro2 = $_GET['semana1'];
    $parametro3 = $_GET['semana2'];
    $mantenimientos = Mantenimiento::getByidMaquinaSemanas($parametro1,$parametro2,$parametro3);
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