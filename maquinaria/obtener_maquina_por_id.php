<?php
/**
 * Obtiene el detalle de la maquina especificado por "idMaquina"
 */

require 'Maquinas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idMaquina'])) {
        $parametro = $_GET['idMaquina'];
        $retorno = Maquinas::getById($parametro);
        if ($retorno) {
            $maquina["estado"] = 1;
            $maquina["maquina"] = $retorno;
            print json_encode($maquina);
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

