<?php

/**
 * Representa el la estructura de las Usuarios
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Usuarios
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Usuarios'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM usuarios";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
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
    public static function getById($idUsuario) {
        $consulta = "SELECT * FROM usuarios WHERE idUsuario = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idUsuario));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idUsuario      identificador
     * @param mas campos
     */
    public static function update($idUsuario,$usuario,$clave,$permisos,$nombre,$apellidoPaterno,$apellidoMaterno) {  
        $consulta = "UPDATE usuarios" .
            " SET usuario=?, clave=?, permisos=?, nombre=?,".
            " apellido_paterno=?, apellido_materno=? " .
            "WHERE idUsuario=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($usuario, $clave, $permisos
                , $nombre, $apellidoPaterno,$apellidoMaterno,$idUsuario));
        return $cmd;
    }

    /**
     * Insertar un nuevo Usuario
     *
     * @param $nombre      nombre del nuevo registro
     * @return PDOStatement
     */
    public static function insert($usuario,$clave,$permisos,$nombre,$apellidoPaterno,$apellidoMaterno) {
        $comando = "INSERT INTO usuarios(usuario,clave,permisos,nombre,apellido_paterno,apellido_materno) VALUES(?,?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($usuario,$clave,$permisos,$nombre,$apellidoPaterno,$apellidoMaterno));
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idAlumno identificador de la tabla Alumnos
     * @return bool Respuesta de la eliminaci�n
     */
    public static function delete($idUsuario)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM usuarios WHERE idUsuario=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idUsuario));
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