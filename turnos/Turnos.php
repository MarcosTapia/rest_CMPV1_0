<?php
/**
 * Representa el la estructura de los turnos
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Turnos
{
    function __construct() {
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'salidas_comedor'
     * @return array Datos del registro
     */
    public static function getAllSalidasComedor() {
        $consulta = "SELECT * FROM salidas_comedor order by idMovimiento desc";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'turnos'
     * @return array Datos del registro
     */
    public static function getAllOnTurn() {
        $consulta = "SELECT * FROM turnos inner join usuarios on turnos.idUsuario "
                . "= usuarios.idUsuario where TIME(hora_entrada) <= CURTIME() and "
                . "TIME(hora_salida) >= CURTIME() order by status;";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }    
    
    /** 
     * Obtiene los campos de una notificacion por semana y usuario con un 
     * identificador determinado
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function obtenerParosConsulta($idResponsable,$week,$idMaquina,$fecha1,$fecha2) {
        $weeks = explode("|",$week);
        $consulta = "";
        if ($idMaquina == 0){ // si viene la maquina/responsable vacia
            if ($idResponsable == 0){ // si viene el reponsable en blanco la consulta es normal por fechas
                if (($fecha1=="") && ($fecha2=="")) { //si todo viene vacio consulta genetal
                    //$consulta = "select * from notificaciones where DATE(fechaEnvioNotificacionAlTecnico) = DATE(NOW())";  
                    $consulta = "select * from notificaciones";  
                } else { /****************  EMIEZO POR ESTA ***************************/
                    if (($fecha1!="") && ($fecha2!="")) { //si vienen las dos fechas pero sin responsable y maquina
                        $consulta = "select * from notificaciones where DATE(fechaEnvioNotificacionAlTecnico) BETWEEN DATE('".$fecha1."') and DATE('".$fecha2."')";  
                    } else { //si viene solo la fecha1  pero sin responsable y maquina
                        $consulta = "select * from notificaciones where DATE(fechaEnvioNotificacionAlTecnico) = DATE('".$fecha1."')";  
                    }
                } 
            } else {
                if (($fecha1=="") && ($fecha2=="")) { //si todo viene vacio consulta por dia excepto tecnico
                    $consulta = "select * from notificaciones where idUsuarioTecnico=".$idResponsable;  
                } else { 
                    if (($fecha1!="") && ($fecha2!="")) { //si vienen las dos fechas pero sin responsable y maquina
                        $consulta = "select * from notificaciones where DATE(fechaEnvioNotificacionAlTecnico) BETWEEN DATE('".$fecha1."') and DATE('".$fecha2."') and idUsuarioTecnico=".$idResponsable;  
                    } else { //si viene solo la fecha1  pero sin responsable y maquina
                        $consulta = "select * from notificaciones where DATE(fechaEnvioNotificacionAlTecnico) = DATE('".$fecha1."') and idUsuarioTecnico=".$idResponsable;  
                    }
                } 
            }
        } else { //si viene una maquina de ahi se toma al responsable
            if ($idResponsable == 0){ // si viene el reponsable en blanco la consulta es normal por fechas
                if (($fecha1=="") && ($fecha2=="")) { //si todo viene vacio consulta por dia
                    $consulta = "select * from notificaciones where idMaqui=".$idMaquina;  
                } else { /****************  EMIEZO POR ESTA ***************************/
                    if (($fecha1!="") && ($fecha2!="")) { //si vienen las dos fechas pero sin responsable y maquina
                        $consulta = "select * from notificaciones where DATE(fechaEnvioNotificacionAlTecnico) BETWEEN DATE('".$fecha1."') and DATE('".$fecha2."') and idMaqui=".$idMaquina;  
                    } else { //si viene solo la fecha1  pero sin responsable y maquina
                        $consulta = "select * from notificaciones where DATE(fechaEnvioNotificacionAlTecnico) = DATE('".$fecha1."') and idMaqui=".$idMaquina;
                    }
                } 
            }
        }
        //$consulta = $consulta." ORDER BY TRIM(SUBSTRING(fechaEnvioNotificacionAlTecnico, 1, 9)) ASC";
        //$consulta = $consulta." ORDER BY fechaEnvioNotificacionAlTecnico ASC";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /** 
     * Obtiene los campos de notificacion por diferentes criterios
     * @param Diferentes criterios
     * @return mixed
     */
    public static function obtenerParosConsultaGraficos($fecha1,$fecha2) {
        $consulta = "select * from notificaciones as noti "
                . "inner join maquinas as maq on noti.idMaqui = maq.idMaquina "
                . "inner join areas as a on maq.idArea = a.idArea "
                . "where DATE(fechaEnvioNotificacionAlTecnico) BETWEEN DATE('".$fecha1."') and DATE('".$fecha2."')";  
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Retorna en la fila especificada de la tabla 'turnos'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM turnos order by status";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'notificaciones'
     * @return array Datos del registro
     */
    public static function getAllNotifications($idUsuario) {
        $consulta = "SELECT * FROM notificaciones WHERE estado = 0 and idUsuario = ".$idUsuario;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un turno con un identificador determinado
     * @param $idTurno Identificador del turno
     * @return mixed
     */
    public static function getById($idTurno) {
        $consulta = "SELECT * FROM turnos WHERE idTurno = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idTurno));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Obtiene los campos de un turno con un identificador determinado
     * @param $idUsuario Identificador del turno por su idUsuarioTecnico
     * @return mixed
     */
    public static function getByIdUsuario($idUsuarioTecnico) {
        $consulta = "SELECT * FROM turnos WHERE idUsuario = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idUsuarioTecnico));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idTurno identificador
     * @param mas campos
     */
    public static function update($idTurno, $idUsuario, $hora_entrada,$hora_salida,$idArea1,$idArea2,$idArea3,$idArea4,$idArea5) {  
        $consulta = "UPDATE turnos SET hora_entrada=?, hora_salida=?, idUsuario=?, idArea1 =?, idArea2 =?, idArea3 =?, idArea4 =?, idArea5 =?" .
            "WHERE idTurno=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($hora_entrada, $hora_salida, $idUsuario,$idArea1,$idArea2,$idArea3,$idArea4,$idArea5,$idTurno));
        return $cmd;
    }

    /**
     * Insertar un nuevo turno
     * @param 
     * @return PDOStatement
     */
    public static function insert($idUsuario,$hora_entrada,$hora_salida,$idArea1,$idArea2,$idArea3,$idArea4,$idArea5) {
        $comando = "INSERT INTO turnos(hora_entrada,hora_salida,idUsuario,idArea1,idArea2,idArea3,idArea4,idArea5) VALUES(?,?,?,?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($hora_entrada,$hora_salida,$idUsuario,$idArea1,$idArea2,$idArea3,$idArea4,$idArea5));
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idTurno identificador de la tabla Turnos
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idTurno) {
        $comando = "DELETE FROM turnos WHERE idTurno=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idTurno));
    }
    
    
    /**
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     * @param $usuario, $claveIdentificador del usuario
     * @return mixed
     */
    public static function verificaUsuario($usuario, $clave) {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? and clave=?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($usuario,md5($clave)));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function userExist($usuario,$clave) {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? and clave = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($usuario,$clave));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
            //return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
}

?>