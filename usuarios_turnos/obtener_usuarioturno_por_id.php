<?php
/**
 * Obtiene el detalle de un usuario especificado por
 * su identificador "idUsuarioOperador"
 */

require 'Usuariosturnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idUsuarioOperador'])) {
        $parametro = $_GET['idUsuarioOperador'];
        $retorno = Usuariosturnos::getById($parametro);
        if ($retorno) {
            $usuario["estado"] = 1;
            $usuario["usuario"] = $retorno;
            print json_encode($usuario);
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

