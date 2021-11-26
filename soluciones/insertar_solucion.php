<?php
/**
 * Insertar una nueva solucion en la base de datos
 */

require 'Soluciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Soluciones::insert(
        $body['descripcionSolucion'],
        $body['evidenciaSolucion'],
        $body['idUsuario'],
        $body['idFalla'],
        $body['fecha']
            );
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
	echo $json_string;
    }
}

?>