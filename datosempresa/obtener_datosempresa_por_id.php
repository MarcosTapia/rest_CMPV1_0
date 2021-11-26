<?php
/**
 * Obtiene el detalle de la Empresa especificado por
 * su identificador "idEmpresa"
 */

require 'DatosEmpresa.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idEmpresa'])) {
        $parametro = $_GET['idEmpresa'];
        $retorno = DatosEmpresa::getById($parametro);
        if ($retorno) {
            $datosEmpresa["estado"] = 1;		// cambio "1" a 1 porque no coge bien la cadena.
            $datosEmpresa["datosEmpresa"] = $retorno;
            print json_encode($datosEmpresa);
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

