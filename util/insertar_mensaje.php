<?php
/**
 * Insertar un nuevo mensaje en la base de datos
 */

require 'Util.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
    // Insertar Sucursal
    $retorno = Util::insertaMensaje(
        $body['mensaje'],$body['fecha']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
	echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
	echo $json_string;
    }
}

?>