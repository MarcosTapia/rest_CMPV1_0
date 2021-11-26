<?php
/**
 * Obtiene el detalle de una falla especificado por
 * su identificador "idFalla"
 */

require 'Fallas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idFalla'])) {
        $parametro = $_GET['idFalla'];
        $retorno = Fallas::getById($parametro);
        if ($retorno) {
            $falla["estado"] = 1;
            $falla["falla"] = $retorno;
            print json_encode($falla);
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

