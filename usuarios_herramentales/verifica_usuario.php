<?php
/**
 * verifica que exista un usuario
 */

require 'Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['usuario']) && isset($_GET['clave'])) {
        $parametro1 = $_GET['usuario'];
        $parametro2 = $_GET['clave'];
        $retorno = Usuarios::verificaUsuario($parametro1,$parametro2);
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

