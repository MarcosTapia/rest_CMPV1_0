<?php
/**
 * Obtiene los registros de la tabla movimientosaplicadores
 * su identificador "idAplicador"
 */

require 'Aplicadores.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $movimientos_aplicador = Aplicadores::getMovsByIdAplicador($_GET['idAplicador']);
    if ($movimientos_aplicador) {
        $datos["estado"] = 1;
        $datos["movimientos_aplicador"] = $movimientos_aplicador;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}


