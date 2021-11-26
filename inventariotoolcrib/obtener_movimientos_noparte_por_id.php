<?php
/**
 * Obtiene los registros de la tabla movimientosinventario
 * su identificador "idAplicador"
 */

require 'InventarioToolcrib.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $movimientos_noparte = InventarioToolcrib::getMovsByIdInventario($_GET['idInventario']);
    if ($movimientos_noparte) {
        $datos["estado"] = 1;
        $datos["movimientos_noparte"] = $movimientos_noparte;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}


