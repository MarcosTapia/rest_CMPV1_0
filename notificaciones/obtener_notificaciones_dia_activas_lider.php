<?php
/**
 * Obtiene todas las notificaciones de la base de datos
 */

require 'Notificaciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idUsuarioOperador'])) {
        $parametro = $_GET['idUsuarioOperador'];
        $notificaciones = Notificaciones::getAllDayLiderActivas($parametro);
        if ($notificaciones) {
            $datos["estado"] = 1;
            $datos["notificaciones"] = $notificaciones;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "Ha ocurrido un error"
            ));
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

