<?php

/**
 * Representa el la estructura de los Proveedores
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Proveedores
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Proveedores'
     * @param $idProveedor Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM proveedores";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un Proveedor con un identificador
     * determinado
     *
     * @param $idProveedor Identificador del alumno
     * @return mixed
     */
    public static function getById($idProveedor)
    {
        // Consulta de la tabla Proveedores
        $consulta = "SELECT *
                             FROM proveedores
                             WHERE idProveedor = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idProveedor));
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
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idProveedor  identificador etc etc
     */
    public static function update($idProveedor,$nombre_empresa,$direccion_empresa,$nombre_contacto
            ,$email_contacto,$numero_telefonico) {  
        $consulta = "UPDATE proveedores" .
            " SET nombre_empresa=?, direccion_empresa=?,".
            " nombre_contacto=?, email_contacto=?, numero_telefonico=? " .
            "WHERE idProveedor=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($nombre_empresa,$direccion_empresa,
            $nombre_contacto,$email_contacto,$numero_telefonico,$idProveedor));
        return $cmd;
    }

    /**
     * Insertar un nuevo Proveedor
     * @return PDOStatement
     */
    public static function insert($nombre_empresa,$direccion_empresa
            ,$nombre_contacto,$email_contacto,$numero_telefonico) {
        $comando = "INSERT INTO proveedores ( " .
            "nombre_empresa," .
            "direccion_empresa," .
            "nombre_contacto," .
            "email_contacto," .
            "numero_telefonico)" .
            " VALUES( ?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($nombre_empresa,$direccion_empresa
            ,$nombre_contacto,$email_contacto,$numero_telefonico)
        );
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idProveedor identificador de la tabla Proveedores
     * @return bool Respuesta de la eliminaci�n
     */
    public static function delete($idProveedor) {
        $comando = "DELETE FROM proveedores WHERE idProveedor=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idProveedor));
    }

    /** nuevo
     * Obtiene los proveedores con un identificador
     * determinado
     *
     * @param $idProveedor Identificador del proveedor
     * @return mixed
     */
    public static function getByIdBusq($idProveedor)
    {
        // Consulta de la tabla proveedores
        $consulta = "select * from proveedores where idProveedor like '"
                .$idProveedor."%'";
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
    
    /** Obtiene los proveedores con un identificador
     * determinado
     *
     * @param $nombre Identificador del cliente
     * @return mixed
     */
    public static function getByNombreBusq($nombre)
    {
        // Consulta de la tabla clientes
        $consulta = "select * from proveedores where nombre like '"
                .$nombre."%'";
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
    
}

?>