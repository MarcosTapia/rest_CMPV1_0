<?php

/**
 * Representa el la estructura de las Fallas
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Fallas
{
    function __construct()
    {
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'fallas' (ultimo registro)
     * @return array Datos del registro
     */
    public static function getLastId() {
        $consulta = "select * from fallas where `idFalla`=(SELECT MAX(`idFalla`) FROM `fallas`)";
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
     * Obtiene los campos de una falla con un identificador
     * determinado
     * @param $idArea Identificador de la area
     * @return mixed
     */
    public static function getById($idFalla) {
        $consulta = "SELECT * FROM fallas inner join usuarios on fallas.idUsuario=usuarios.idUsuario inner join maquinas on fallas.idMaquina=maquinas.idMaquina WHERE idFalla = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idFalla));
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
     * Insertar una nueva falla
     * @return PDOStatement
     */
    public static function insert($descripcionFalla,$evidenciaFalla,$idUsuario,$idMaquina,$fecha) {
        $comando = "INSERT INTO fallas (descripcionFalla,evidenciaFalla,idUsuario,idMaquina,fecha) VALUES(?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($descripcionFalla,$evidenciaFalla,$idUsuario,$idMaquina,$fecha)
        );

    }

    /**
     * Eliminar el registro con el identificador especificado EN CASCADA CON SOLUCIONES_FALLAS
     * @param $idFalla identificador de la tabla fallas
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idFalla,$tipoborrado) {
        $comando = "";
        if ($tipoborrado == 1) {
            $comando = "delete soluciones_fallas,fallas from soluciones_fallas join fallas on soluciones_fallas.idFalla=fallas.idFalla where soluciones_fallas.idFalla=?";
        } else {
            $comando = "DELETE FROM fallas WHERE idFalla=?";
        }
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idFalla));
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