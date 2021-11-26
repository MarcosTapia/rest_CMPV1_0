<?php

/**
 * Representa el la estructura de las Notificaciones
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Notificaciones {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'notificaciones' por dia lider
     * @return array Datos del registro
     */
    public static function getAllTecnico($idUsuarioTecnico) {
        $consulta = "SELECT * FROM notificaciones where idUsuarioTecnico = ".$idUsuarioTecnico." order by id desc";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }    
    
    /**
     * Retorna en la fila especificada de la tabla 'notificaciones' por dia lider
     * @return array Datos del registro
     */
    public static function getAllLider($idUsuarioOperador) {
        $consulta = "SELECT * FROM notificaciones where idUsuarioOperador = ".$idUsuarioOperador." order by id desc";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }    

    /**
     * Retorna en la fila especificada de la tabla 'notificaciones' por dia lider activas
     * @return array Datos del registro
     */
    public static function getAllDayLiderActivas($idUsuarioOperador) {
        $consulta = "SELECT * FROM notificaciones where idUsuarioOperador = ".$idUsuarioOperador." and DATE(fechaEnvioNotificacionAlTecnico) = DATE(NOW()) and "
                . "TIME(hora_entrada) <= CURTIME() and TIME(hora_salida) >= CURTIME()";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'notificaciones' por dia lider
     * @return array Datos del registro
     */
    public static function getAllDayLider($idUsuarioOperador) {
        $consulta = "SELECT * FROM notificaciones where idUsuarioOperador = ".$idUsuarioOperador." and DATE(fechaEnvioNotificacionAlTecnico) = DATE(NOW()) order by estado";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'notificaciones' por dia
     * @return array Datos del registro
     */
    public static function getAllDay() {
        $consulta = "SELECT * FROM notificaciones where DATE(fechaEnvioNotificacionAlTecnico) = DATE(NOW()) order by id desc";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'Notificaciones'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM notificaciones order by idUsuarioTecnico";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una Notificaion con un identificador determinado
     * @param $id Identificador de la notificacion
     * @return mixed
     */
    public static function getById($idNotificacion) {
        $consulta = "SELECT * FROM notificaciones WHERE id = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idNotificacion));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     */
    public static function updateObservacionesTecnico($idNotificacion,$obsTecnico) {  
        $consulta = "UPDATE notificaciones SET observaciones_tecnico=? WHERE id=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($obsTecnico,$idNotificacion));
        return $cmd;
    }

    /**
     * Insertar un nuevo Usuario
     *
     * @param $nombre      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($descripcion) {
        $comando = "INSERT INTO areas (descripcion) VALUES(?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($descripcion)
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idArea identificador de la tabla Areas
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idArea) {
        $comando = "DELETE FROM areas WHERE idArea=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idArea));
    }
    
    
    /**
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     *
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function verificaUsuario($usuario, $clave)
    {
        // Consulta de la tabla Alumnos
        $consulta = "SELECT *
                             FROM usuarios
                             WHERE usuario = ? and clave=?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($usuario,  md5($clave)));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return -1;
        }
    }
    
    /** nuevo
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     *
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function getByIdBusq($idUsuario)
    {
        // Consulta de la tabla Alumnos
        $consulta = "select * from usuarios where idUsuario like '"
                .$idUsuario."%'";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
//            return $comando->fetchAll(PDO::FETCH_ASSOC);
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /** nuevo
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     *
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function getByNombreBusq($nombre)
    {
        // Consulta de la tabla Alumnos
        $consulta = "select * from usuarios where concat(nombre,' ',apellido_paterno,' ',apellido_materno) like '"
                .$nombre."%'";
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