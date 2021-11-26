<?php
/**
 * Obtiene todas las usuarios de la base de datos para la aplicacion turnos
 */

require 'Usuariosturnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $usuarios = Usuariosturnos::getAll();
    if ($usuarios) {
        $datos["estado"] = 1;
        $datos["usuarios"] = $usuarios;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}
