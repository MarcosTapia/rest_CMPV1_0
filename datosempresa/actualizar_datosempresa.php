<?php
/**
 * Actualiza datos Empresa especificado por su identificador
 */

require 'DatosEmpresa.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = DatosEmpresa::update(
        $body['idEmpresa'],
        $body['nombreEmpresa'],
        $body['rfcEmpresa'],
        $body['direccionEmpresa'],
        $body['emailEmpresa'],
        $body['telEmpresa'],
        $body['cpEmpresa'],
        $body['ciudadEmpresa'],
        $body['estadoEmpresa'],
        $body['paisEmpresa']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Actualizacion correcta"));
	echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se actualizo el registro"));
	echo $json_string;
    }
}
?>
