<?php

/**
 * Representa el la estructura de las Fallasnotificaciones
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Fallasnotificaciones {
    function __construct() {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Fallasnotificaciones'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM fallas_notificaciones";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    
    /**
     * Retorna las filas especificada de la tabla 'Fallasnotificaciones'
     * @return array Datos del registro
     */
    public static function getAllByIdArea($idArea) {
        $consulta = "SELECT * FROM fallas_notificaciones where idArea=".$idArea;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

}

?>