<?php
/**
 * Actualiza una actividad especificado por su identificador
 */

require 'Actividades.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Actividades::update($body['idActividad'],$body['descripcion_actividad'],
            $body['frecuencia'],$body['nombre_maquina']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Actualizacion correcta"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se actualizo el registro"));
		echo $json_string;
    }
}
?>
