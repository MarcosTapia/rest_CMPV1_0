<?php
/**
 * Obtiene el detalle de un usuario para busqueda
 */

require 'Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idUsuario'])) {
        // Obtener par�metro idusuario
        $parametro = $_GET['idUsuario'];
        // Tratar retorno
        $retorno = Usuarios::getByIdBusq($parametro);
        if ($retorno) {
            $usuario["estado"] = 1;		// cambio "1" a 1 porque no coge bien la cadena.
            $usuario["usuario"] = $retorno;
            // Enviar objeto json del alumno
            print json_encode($usuario);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
        }
    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

