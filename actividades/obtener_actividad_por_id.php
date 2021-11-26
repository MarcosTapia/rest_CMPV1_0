<?php
/**
 * Obtiene el detalle de la actividad especificado por "idActividad"
 */

require 'Actividades.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idActividad'])) {
        $parametro = $_GET['idActividad'];
        $retorno = Actividades::getById($parametro);
        if ($retorno) {
            $actividad["estado"] = 1;
            $actividad["actividad"] = $retorno;
            print json_encode($actividad);
        } else {
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
        }
    } else {
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

