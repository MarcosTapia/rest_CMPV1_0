<?php
/**
 * Obtiene el detalle de un proveedor para busqueda por nombre
 */

require 'Proveedores.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['nombre'])) {
        // Obtener parametro nombre
        $parametro = $_GET['nombre'];
        // Tratar retorno
        $retorno = Proveedores::getByNombreBusq($parametro);
        if ($retorno) {
            $proveedor["estado"] = 1;		// cambio "1" a 1 porque no coge bien la cadena.
            $proveedor["proveedor"] = $retorno;
            // Enviar objeto json del proveedor
            print json_encode($proveedor);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
        }
    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

