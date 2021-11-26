<?php

/**
 * Representa el la estructura de las Usuarios en la aplicacion turnos
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Usuariosturnos {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'usuariosoperadores'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM usuariosoperadores";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un Usuario operador con un identificador determinado
     * @param $idUsuarioOperador Identificador del usuario
     * @return mixed
     */
    public static function getById($idUsuarioOperador) {
        $consulta = "SELECT * FROM usuariosoperadores WHERE idUsuarioOperador = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idUsuarioOperador));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idUsuarioOperador      identificador
     * @param mas campos
     */
    public static function update($idUsuarioOperador,$usuario,$clave,$permisos,$nombre,$apellidoPaterno,$apellidoMaterno,$idArea) {  
        $consulta = "UPDATE usuariosoperadores" .
            " SET usuario=?, clave=?, permisos=?, nombre=?,".
            " apellido_paterno=?, apellido_materno=?, idArea=? " .
            "WHERE idUsuarioOperador=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($usuario,$clave,$permisos,$nombre,$apellidoPaterno,$apellidoMaterno,$idArea,$idUsuarioOperador));
        return $cmd;
    }

    /**
     * Insertar un nuevo Usuario para la aplicacion de usuarios turnos
     * @param $nombre      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($usuario,$clave,$permisos,$nombre,$apellidoPaterno,$apellidoMaterno,$idArea) {
        $comando = "INSERT INTO usuariosoperadores(usuario,clave,permisos,nombre,apellido_paterno,apellido_materno,idArea) VALUES(?,?,?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($usuario,$clave,$permisos,$nombre,$apellidoPaterno,$apellidoMaterno,$idArea));
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idUsuarioOperador identificador de la tabla usuariosoperadores
     * @return bool Respuesta de la eliminaci�n
     */
    public static function delete($idUsuarioOperador) {
        $comando = "DELETE FROM usuariosoperadores WHERE idUsuarioOperador=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idUsuarioOperador));
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
    
    /**
     * Obtiene los campos de un Usuario Operador con un identificador
     * determinado
     * @param $idUsuario Identificador del alumno
     * @return mixed
     */
    public static function userExistOperators($usuario,$clave) {
        $consulta = "SELECT * FROM usuariosoperadores WHERE usuario = ? and clave = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($usuario,$clave));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }
    
}

?>