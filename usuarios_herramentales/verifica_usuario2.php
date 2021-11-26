<?php
/**
 * verifica que exista un usuario en la base de datos
 */

require 'Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Usuarios::userExist($body['usuario'],$body['clave']);
    if ($retorno) {
        $usuario["estado"] = 1;
        $usuario["usuario"] = $retorno;
        print json_encode($usuario);
    } else {
        print json_encode(
            array(
                'estado' => '2',
                'mensaje' => 'No se obtuvo el registro'
            )
        );
    }    
}

?>