<?php
/**
 * Obtiene el detalle de un proveedor especificado por
 * su identificador "idProveedor"
 */

require 'Proveedores.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['idProveedor'])) {

        // Obtener par�metro idProveedor
        $parametro = $_GET['idProveedor'];

        // Tratar retorno
        $retorno = Proveedores::getById($parametro);


        if ($retorno) {

            $proveedor["estado"] = 1;		// cambio "1" a 1 porque no coge bien la cadena.
            $proveedor["proveedor"] = $retorno;
            // Enviar objeto json del Proveedor
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

