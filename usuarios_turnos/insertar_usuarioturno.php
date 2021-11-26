<?php
/**
 * Insertar un nuevo usuario en la base de datos
 */

require 'Usuariosturnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Usuariosturnos::insert($body['usuario'],$body['clave'],$body['permisos'],$body['nombre'],$body['apellido_paterno'],$body['apellido_materno'],$body['idArea']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
		echo $json_string;
    }
}

?>