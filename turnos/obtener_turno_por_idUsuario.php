<?php
/**
 * Obtiene el detalle de un turno especificado por
 * su identificador "idUsuario"
 */

require 'Turnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idUsuario'])) {
        $parametro = $_GET['idUsuario'];
        $retorno = Turnos::getByIdUsuario($parametro);
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

