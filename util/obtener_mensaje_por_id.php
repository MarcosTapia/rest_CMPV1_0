<?php
/**
 * Obtiene el detalle de un mensaje especificado por
 * su identificador "idMensaje"
 */

require 'Util.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idMensaje'])) {
        // Obtener parametro idSucursal
        $parametro = $_GET['idMensaje'];
        // Tratar retorno
        $retorno = Util::getMensajeById($parametro);
        if ($retorno) {
            $mensaje["estado"] = 1;		// cambio "1" a 1 porque no coge bien la cadena.
            $mensaje["mensaje"] = $retorno;
            // Enviar objeto json del mensaje
            print json_encode($mensaje);
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

