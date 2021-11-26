<?php
/**
 * Actualiza una categoria especificada por su identificador
 */

require 'Categorias.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Categorias::update(
        $body['idCategoria'],
        $body['descripcion_categoria']
            );
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Actualizacion correcta"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se actualizo el registro"));
	echo $json_string;
    }
}
?>