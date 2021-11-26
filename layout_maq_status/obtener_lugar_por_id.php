<?php
/**
 * Obtiene el detalle de un lugar especificado por
 * su identificador "id"
 */

require 'Layoutmaqstatus.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $parametro = $_GET['id'];
        $retorno = Layoutmaqstatus::getById($parametro);
        if ($retorno) {
            $lugar["estado"] = 1;
            $lugar["lugar"] = $retorno;
            print json_encode($lugar);
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

