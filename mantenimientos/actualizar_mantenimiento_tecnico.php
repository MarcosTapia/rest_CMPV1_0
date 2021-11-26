<?php
/** Actualiza un mantenimiento especificado por su identificador */

require 'Mantenimiento.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Mantenimiento::updateByTecnico(
        $body['idFechaMantenimiento'],
        $body['fechaMantenimiento'],
        $body['observaciones_maquina'],
        $body['ruta']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Actualizacion correcta"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se actualizo el registro"));
	echo $json_string;
    }
}
?>
