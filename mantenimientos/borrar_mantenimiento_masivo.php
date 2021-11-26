<?php
/**
 * Elimina un mantenimiento de la base de datos
 * distinguido por su identificador
 */

require 'Mantenimiento.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Mantenimiento::deleteMantoMasivo($body['idMaqElim'],$body['idRespElim']);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Eliminacion exitosa"));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se elimino el registro"));
        echo $json_string;
    }
}
?>