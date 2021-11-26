<?php
/**
 * Obtiene el detalle de una solucion especificado por
 * su identificador "idSolucion"
 */

require 'Soluciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idSolucion'])) {
        $parametro = $_GET['idSolucion'];
        $retorno = Soluciones::getById($parametro);
        if ($retorno) {
            $solucion["estado"] = 1;
            $solucion["solucion"] = $retorno;
            print json_encode($solucion);
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

