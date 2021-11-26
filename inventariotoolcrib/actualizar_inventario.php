<?php
/**
 * Actualiza un numero de parte especificado por su identificador
 */

require 'InventarioToolcrib.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = InventarioToolcrib::update(
        $body['idInventario'],
        $body['numSAP'],
        $body['maquina'],
        $body['descripcion'],
        $body['numParte'],
        $body['ubicacion'],
        $body['stock'],
        $body['minimo'],
        $body['maximo'],
        $body['idProveedor'],
        $body['idUsuario'],
        $body['cantidad']            
            );
    
    //$json_string = json_encode(array("estado" => 1,"mensaje" => $body['maquina']." ** ".$body['idUsuario']." ** ".$body['cantidad']));
    //echo $json_string;
    
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Actualizacion correcta"));
	echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se actualizo el registro"));
	echo $json_string;
    }
}
?>
