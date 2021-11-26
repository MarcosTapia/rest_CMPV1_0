<?php

/**
 * Funciones utiles del sistema
 */
require '../db/Database.php';

class Util
{
    function __construct()
    {
    }
  
 
    /*
         envia correo

     */
    public static function enviaCorreo($mensaje, $remitente,$destinatario, $titulo,$negocio) {
       /* $mail = $mensaje;
        //cabecera
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
        //dirección del remitente 
        $headers .= "From: ".$negocio." < ".$remitente." >\r\n";
        //Enviamos el mensaje a tu_dirección_email 
        $bool = mail($destinatario,$titulo,$mail,$headers);
        return $bool;*/
       
$destinatario = "marcostapia623@gmail.com"; 
$asunto = "aaaaaaaaa->"; 
$cuerpo = ' 
<html> 
<head> 
   <title>Prueba de correo</title> 
</head> 
<body> 
<h1>Hola amigos!</h1> 
<p> 
<b>Bienvenidos a mi correo electrónico de prueba</b>. Estoy encantado de tener tantos lectores. Este cuerpo del mensaje es del artículo de envío de mails por PHP. Habría que cambiarlo para poner tu propio cuerpo. Por cierto, cambia también las cabeceras del mensaje. 
</p> 
</body> 
</html> 
'; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: Matservices <mtapia_soto@hotmail.com>\r\n"; 

$bool = mail($destinatario,$asunto,$cuerpo,$headers);
return $bool;
               
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'mensajes'
     *
     * @param $fIni,$fFin Identificador del registro
     * @return array Datos del registro
     */
    public static function obtieneMensajesPorFechas($fIni,$fFin)
    {
        $consulta = "SELECT * FROM mensajes WHERE DATE(fecha) BETWEEN ? AND ? ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($fIni,$fFin));
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Retorna en la fila especificada de la tabla 'mensajes'
     *
     * @return array Datos del registro
     */
    public static function obtenerMensajes()
    {
        $consulta = "SELECT * FROM mensajes";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un mensaje con un identificador
     * determinado
     * @param $idMensaje Identificador del mensaje
     * @return mixed
     */
    public static function getMensajeById($idMensaje)
    {
        // Consulta de la tabla Sucursales
        $consulta = "SELECT *
                             FROM mensajes
                             WHERE idMensaje = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idMensaje));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return -1;
        }
    }
    
    /**
     * Insertar un nuevo mensaje
     *
     * @param $mensaje,$fecha      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insertaMensaje($mensaje,$fecha){
        // Sentencia INSERT
        $comando = "INSERT INTO mensajes (mensaje,fecha) VALUES(?,?)";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array(
                $mensaje,$fecha)
        );
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idMensaje identificador de la tabla mensajes
     * @return bool Respuesta de la eliminacion
     */
    public static function borraMensaje($idMensaje)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM mensajes WHERE idMensaje=?";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idMensaje));
    }
    
    /**
     * Retorna la fecha del servidor
     *
     * @return array Datos del registro
     */
    public static function obtenerFechaServidor()
    {
        $consulta = "SELECT SYSDATE()";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
}

?>