<?php
/**
 * Obtiene todas las actividades de la base de datos
 */

require 'Actividades.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    /*
    if (isset($_GET['idUsuario'])) {
        $parametro = $_GET['idActividad'];
        $actividades = Actividades::getAllTecnico($parametro);
        if ($actividades) {
            $datos["estado"] = 1;
            $datos["actividades"] = $actividades;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "Ha ocurrido un error"
            ));
        }
    } else {
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
     * 
     */
}

