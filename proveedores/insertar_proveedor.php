<?php
/**
 * Insertar un nuevo proveedor en la base de datos
 */

require 'Proveedores.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Proveedores::insert(
        $body['nombre_empresa'],
        $body['direccion_empresa'],
        $body['nombre_contacto'],
        $body['email_contacto'],
        $body['numero_telefonico']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
	echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
	echo $json_string;
    }
}

?>