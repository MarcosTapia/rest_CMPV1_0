<?php
/**
 * Actualiza un proveedor especificado por su identificador
 */

require 'Proveedores.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Proveedores::update(
        $body['idProveedor'],
        $body['nombre_empresa'],
        $body['direccion_empresa'],
        $body['nombre_contacto'],
        $body['email_contacto'],
        $body['numero_telefonico']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Actualizacion correcta"));
	echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se actualizo el registro"));
	echo $json_string;
    }
}
?>
