<?php
/**
 * Obtiene todas las soluciones por id de la base de datos
 */

require 'Soluciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idFalla'])) {
        $parametro = $_GET['idFalla'];
        $soluciones = Soluciones::getAllByIdFalla($parametro);
        if ($soluciones) {
            $datos["estado"] = 1;
            $datos["soluciones"] = $soluciones;
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

