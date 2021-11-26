<?php
/**
 * Obtiene el detalle de una notificacion especificado por
 * su identificador "id"
 */

require 'Notificaciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $parametro = $_GET['id'];
        $retorno = Notificaciones::getById($parametro);
        if ($retorno) {
            $notificacion["estado"] = 1;
            $notificacion["notificacion"] = $retorno;
            print json_encode($notificacion);
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

