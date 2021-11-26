<?php

/**
 * Representa el la estructura de las soluciones
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Soluciones
{
    function __construct()
    {
    }
    
    /**
     * Retorna las filas especificada de la tabla 'Fallas'
     * @return array Datos del registro
     */
    public static function getAllByIdFalla($idFalla) {
        $consulta = "SELECT * FROM soluciones_fallas  as sf inner join usuarios as usu on sf.idUsuario = usu.idUsuario inner join fallas on sf.idFalla = fallas.idFalla where sf.idFalla=".$idFalla;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return False;
        }
    }
    
    
    /**
     * Retorna en la fila especificada de la tabla 'soluciones' (ultimo registro)
     * @return array Datos del registro
     */
    public static function getLastId() {
        $consulta = "select * from soluciones_fallas where `idSolucion`=(SELECT MAX(`idSolucion`) FROM `soluciones_fallas`)";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    

    /**
     * Retorna las filas especificada de la tabla 'Fallas'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM fallas inner join usuarios on fallas.idUsuario=usuarios.idUsuario inner join maquinas on fallas.idMaquina=maquinas.idMaquina";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una solucion con un identificador
     * determinado
     * @param $idSolucion Identificador de la solucion
     * @return mixed
     */
    public static function getById($idSolucion) {
        $consulta = "SELECT * FROM soluciones_fallas as sf inner join usuarios on "
                . "sf.idUsuario=usuarios.idUsuario inner join fallas on sf.idFalla=fallas.idFalla WHERE idSolucion = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idSolucion));
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
    public static function update($idArea,$descripcion) {  
        $consulta = "UPDATE areas SET descripcion=? WHERE idArea=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($descripcion,$idArea));
        return $cmd;
    }

    /**
     * Insertar una nueva solucion
     * @return PDOStatement
     */
    public static function insert($descripcionSolucion,$evidenciaSolucion,$idUsuario,$idFalla,$fecha) {
        $comando = "INSERT INTO soluciones_fallas (descripcionSolucion,idFalla,evidenciaSolucion,idUsuario,fecha) VALUES(?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($descripcionSolucion,$idFalla,$evidenciaSolucion,$idUsuario,$fecha)
        );
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idSolucion identificador de la tabla soluciones_fallas
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idSolucion) {
        $comando = "DELETE FROM soluciones_fallas WHERE idSolucion=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idSolucion));
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