<?php
/**
 * Obtiene todas las notificaciones de la base de datos
 */

require 'Turnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $notificaciones = Turnos::getAllNotifications($_GET['idUsuario']);
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
}

