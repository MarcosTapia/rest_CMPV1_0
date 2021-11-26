<?php
/**
 * Actualiza un usuario especificado por su identificador
 */

require 'Usuariosturnos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Usuariosturnos::update(
        $body['idUsuarioOperador'],
        $body['usuario'],
        $body['clave'],
        $body['permisos'],
        $body['nombre'],
        $body['apellido_paterno'],
        $body['apellido_materno'],
        $body['idArea']
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
