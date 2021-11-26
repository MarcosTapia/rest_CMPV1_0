<?php

/**
 * Representa el la estructura de la ubicacion en Layoutmaqstatus
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Layoutmaqstatus {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Layoutmaqstatus'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM layout_maq_status lms inner join maquinas on lms.idMaq = maquinas.idMaquina";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un lugar con un identificador determinado
     * @param $id Identificador del lugar
     * @return mixed
     */
    public static function getById($id) {
        $consulta = "SELECT * FROM layout_maq_status WHERE id = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($id));
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
    public static function update($id,$idMaquina,$control,$status) {  
        $consulta = "UPDATE layout_maq_status SET idMaq=?,control=?,status=? WHERE id=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($idMaquina,$control,$status,$id));
        return $cmd;
    }

    /**
     * Insertar un nuevo Lugar
     * @param idMaquina,lugar  del nuevo registro
     * @return PDOStatement
     */
    public static function insert($idMaquina,$control) {
        $comando = "INSERT INTO layout_maq_status (idMaq,control,idNotificacion) VALUES(?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($idMaquina,$control,1)
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $id identificador de la tabla  layout_maq_status
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($id) {
        $comando = "DELETE FROM layout_maq_status WHERE id=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($id));
    }    
    
}

?>