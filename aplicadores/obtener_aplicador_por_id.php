<?php
/**
 * Obtiene el detalle de un aplicador especificado por
 * su identificador "idAplicador"
 */

require 'Aplicadores.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idAplicador'])) {
        $parametro = $_GET['idAplicador'];
        $retorno = Aplicadores::getById($parametro);
        if ($retorno) {
            $aplicador["estado"] = 1;
            $aplicador["aplicador"] = $retorno;
            print json_encode($aplicador);
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
                'mensaje' => $_GET['idAplicador']
            )
        );
    }
}

