<?php
/**
 * Obtiene el detalle de una categoria especificado por
 * su identificador "idCategoria"
 */

require 'Categorias.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idCategoria'])) {
        $parametro = $_GET['idCategoria'];
        $retorno = Categorias::getById($parametro);
        if ($retorno) {
            $categoria["estado"] = 1;
            $categoria["categoria"] = $retorno;
            print json_encode($categoria);
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

