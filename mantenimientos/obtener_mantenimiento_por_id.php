<?php
/**
 * Obtiene el registro del mantenimiento
 * su identificador "idFechaMantenimiento"
 */

require 'Mantenimiento.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idFechaMantenimiento'])) {
        $parametro = $_GET['idFechaMantenimiento'];
        $retorno = Mantenimiento::getById($parametro);
        if ($retorno) {
            $mantenimiento["estado"] = 1;
            $mantenimiento["mantenimiento"] = $retorno;
            print json_encode($mantenimiento);
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

