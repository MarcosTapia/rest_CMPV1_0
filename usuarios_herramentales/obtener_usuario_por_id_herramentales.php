<?php
/**
 * Obtiene el detalle de un usuario_herramental especificado por
 * su identificador "idUsuario"
 */

require 'UsuariosHerramentales.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idUsuario'])) {
        $parametro = $_GET['idUsuario'];
        $retorno = UsuariosHerramentales::getById($parametro);
        if ($retorno) {
            $usuario["estado"] = 1;
            $usuario["usuario_herramental"] = $retorno;
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

