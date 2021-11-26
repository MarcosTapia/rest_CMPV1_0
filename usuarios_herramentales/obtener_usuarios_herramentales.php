<?php
/**
 * Obtiene todas las usuarios de la base de datos
 */

require 'UsuariosHerramentales.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $usuarios_herramentales = UsuariosHerramentales::getAll();
    if ($usuarios_herramentales) {
        $datos["estado"] = 1;
        $datos["usuarios_herramentales"] = $usuarios_herramentales;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

