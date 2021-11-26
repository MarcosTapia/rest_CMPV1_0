<?php
/**
 * Obtiene todas las usuarios operadores lideres/supervisores
 */

require 'Usuariosoperadores.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $usuarios = Usuariosoperadores::getAll();
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

