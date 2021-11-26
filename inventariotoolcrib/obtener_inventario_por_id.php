<?php
/**
 * Obtiene el detalle de una parte especificado por
 * su identificador "idProveedor"
 */

require 'InventarioToolcrib.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idInventario'])) {
        $parametro = $_GET['idInventario'];
        $retorno = InventarioToolcrib::getById($parametro);
        if ($retorno) {
            $inventario["estado"] = 1;
            $inventario["inventario"] = $retorno;
            print json_encode($inventario);
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

