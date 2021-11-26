<?php
/**
 * Insertar un nuevo numero en la base de datos
 */

require 'InventarioToolcrib.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = InventarioToolcrib::insert(
        $body['numSAP'],
        $body['maquina'],
        $body['descripcion'],
        $body['numParte'],
        $body['ubicacion'],
        $body['stock'],
        $body['minimo'],
        $body['maximo'],
        $body['idProveedor']
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

        

