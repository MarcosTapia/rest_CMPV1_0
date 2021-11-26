<?php
/**
 * Obtiene todas las maquinas de la base de datos
 */

require 'Maquinas.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['responsable_maquina'])) {
        $parametro = $_GET['responsable_maquina'];
        $maquinas = Maquinas::getByUser($parametro);
        if ($maquinas) {
            $datos["estado"] = 1;
            $datos["maquinas"] = $maquinas;
            print json_encode($datos);
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
?>