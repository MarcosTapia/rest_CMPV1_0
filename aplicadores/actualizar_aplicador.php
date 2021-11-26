<?php
/**
 * Actualiza un apliacdor especificada por su identificador
 */

require 'Aplicadores.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Aplicadores::update(
        $body['maquina'],
        $body['aplicador'],
        $body['fabricante'],
        $body['noParteAplicador'],
        $body['noParteTerminal'],
        $body['noParteTerminalInterno'],
        $body['cliente'],
        $body['noCiclos'],
        $body['idAplicador']
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
