<?php
/**
 * Envia correo
 */

require 'Util.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
    $destinatario = $body['destinatario']; 
    $asunto = $body['titulo']; 
    //para el env¨ªo en formato HTML 
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    //direcci¨®n del remitente 	$headers .= "From: Matservices <matservices07@gmail.com>\r\n"; 
    $enviado = mail($destinatario,$asunto,$body['mensaje'],$headers) ;
    print json_encode(array(
	"estado" => 1,
	"mensaje" => "Correo Eniviado"
      ));       
}
    
    
        
    
