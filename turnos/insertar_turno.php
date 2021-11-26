<?php
/**
 * Insertar un nuevo turno en la base de datos
 */

require 'Turnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Turnos::insert($body['idUsuario'],$body['hora_entrada'],$body['hora_salida'],$body['idArea1'],$body['idArea2'],$body['idArea3'],$body['idArea4'],$body['idArea5']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
		echo $json_string;
    }
}

?>