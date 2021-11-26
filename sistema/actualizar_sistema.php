<?php
/**
 * Actualiza los parametros del sistema especificado por su identificador
 */

require 'Sistema.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);

    // Actualizar usuario
    $retorno = Sistema::update(
        $body['idSistema'],
        $body['ivaEmpresa'],
        $body['historicoProveedores'],
        $body['criterioHistoricoProveedores'],
        $body['camposInventario'],
        $body['camposVentas'],
        $body['camposCompras'],
        $body['camposConsultas'],
        $body['camposProveedores'],
        $body['camposClientes'],
        $body['camposEmpleados'],
        $body['camposEmpresa'],
        $body['ivaGral']       
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
