<?php
/**
 * Obtiene el detalle de una area especificado por
 * su identificador "idArea"
 */

require 'Areas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idArea'])) {
        $parametro = $_GET['idArea'];
        $retorno = Areas::getById($parametro);
        if ($retorno) {
            $area["estado"] = 1;
            $area["area"] = $retorno;
            print json_encode($area);
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

