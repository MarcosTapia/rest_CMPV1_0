<?php
/**
 * Insertar una nuevo movimiento de aplicador en la base de datos
 * para iniciar tracking
 */

require 'Aplicadores.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Aplicadores::insertMovAplicador(
        $body['idAplicador'],
        $body['ciclos'],
        $body['idUsuario']
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