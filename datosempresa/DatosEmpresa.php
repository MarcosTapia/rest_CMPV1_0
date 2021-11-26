<?php

/**
 * Representa el la estructura de los Datos de la Empresa
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class DatosEmpresa
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'datosempresa'
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM datosempresa";
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
     * Obtiene los campos de los datos de la empresa con un identificador
     * determinado
     * @param $idEmpresa Identificador de la empresa
     * @return mixed
     */
    public static function getById($idEmpresa)
    {
        $consulta = "SELECT * FROM datosempresa WHERE idEmpresa = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idEmpresa));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idEmpresa      identificador etc, etc
     */
    public static function update($idEmpresa,$nombreEmpresa,$rfcEmpresa,$direccionEmpresa,$emailEmpresa,$telEmpresa,$cpEmpresa,$ciudadEmpresa,$estadoEmpresa,$paisEmpresa) {  
        $consulta = "UPDATE datosempresa" .
            " SET nombreEmpresa=?, rfcEmpresa=?, direccionEmpresa=?, emailEmpresa=?,".
            " telEmpresa=?, cpEmpresa=?, ciudadEmpresa=?, estadoEmpresa=?, paisEmpresa=? " .
            "WHERE idEmpresa=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($nombreEmpresa,$rfcEmpresa,$direccionEmpresa,
                $emailEmpresa,$telEmpresa,$cpEmpresa,$ciudadEmpresa,
                $estadoEmpresa,$paisEmpresa,$idEmpresa));
        return $cmd;
    }

}

?>