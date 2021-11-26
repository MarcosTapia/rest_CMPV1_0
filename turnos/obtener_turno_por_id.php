<?php
/**
 * Obtiene el detalle de un turno especificado por
 * su identificador "idTurno"
 */

require 'Turnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idTurno'])) {
        $parametro = $_GET['idTurno'];
        $retorno = Turnos::getById($parametro);
        if ($retorno) {
            $turno["estado"] = 1;
            $turno["turno"] = $retorno;
            print json_encode($turno);
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

