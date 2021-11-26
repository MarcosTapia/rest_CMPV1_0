<?php
/**
 * Obtiene el detalle de la Empresa especificado por
 * su identificador "idEmpresa"
 */

require 'Sistema.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['idSistema'])) {

        // Obtener parametro idEmpresa
        $parametro = $_GET['idSistema'];

        // Tratar retorno
        $retorno = Sistema::getById($parametro);


        if ($retorno) {

            $sistema["estado"] = 1;		// cambio "1" a 1 porque no coge bien la cadena.
            $sistema["sistema"] = $retorno;
            // Enviar objeto json de configuracion del sistema
            print json_encode($sistema);
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

