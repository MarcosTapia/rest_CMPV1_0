<?php

/**
 * Representa el la estructura de las Maquinas
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Maquinas {
    function __construct() {
    }
    
    /** 
     * Obtiene las maquinas por idArea
     * @return mixed
     */
    public static function getByidArea($idArea) {
		//antes
        $consulta = "select * from maquinas where idArea = ".$idArea;
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }    

    /**
     * Retorna en la fila especificada de la tabla 'Alumnos'
     *
     * @param $idAlumno Identificador del registro
     * @return array Datos del registro
     */
    public static function getAllSimple() {
        $consulta = "SELECT * from maquinas";
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
     * Retorna en la fila especificada de la tabla 'Alumnos'
     *
     * @param $idAlumno Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT m.idMaquina, m.numero_maquina, m.nombre_maquina, m.responsable_maquina, m.status,
                u.apellido_paterno as apusu, u.apellido_materno as amusu, u.nombre as nomusu, a.idArea, cate.descripcion_categoria, a.descripcion,
                prov.idProveedor, prov.nombre_empresa as nomprov FROM 
                maquinas as m 
                inner join usuarios as u on m.responsable_maquina = u.idUsuario 
		inner join areas as a on m.idArea = a.idArea 
                inner join proveedores as prov on m.idProveedor = prov.idProveedor 
                inner join categorias_maquinas as cate on m.idCategoria=cate.idCategoria 
                order by m.nombre_maquina";
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
     * Retorna en la fila especificada de la tabla 'Alumnos'
     *
     * @param $idAlumno Identificador del registro
     * @return array Datos del registro
     */
    public static function getAllActivesWithActivities() {
//        $consulta = "SELECT m.idMaquina, m.numero_maquina, m.nombre_maquina, m.responsable_maquina, m.status,
//                u.apellido_paterno as apusu, u.apellido_materno as amusu, u.nombre as nomusu, a.idArea, a.descripcion,
//                prov.idProveedor, prov.nombre_empresa as nomprov FROM 
//                maquinas as m inner join usuarios as u on m.responsable_maquina = u.idUsuario 
//		inner join areas as a on m.idArea = a.idArea inner join proveedores as prov on 
//                m.idProveedor = prov.idProveedor 
//                INNER JOIN actividades as act on m.idMaquina = act.idMaquina where m.status = 1";
        
        $consulta = "SELECT * FROM maquinas as m INNER JOIN actividades as act on m.idMaquina = act.idMaquina where m.status = 1";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getAllActivesSinOrdenar() { //Antes de la peticion de ordenar
        $consulta = "SELECT m.idMaquina, m.numero_maquina, m.nombre_maquina, m.responsable_maquina, m.status,
                u.apellido_paterno as apusu, u.apellido_materno as amusu, u.nombre as nomusu, a.idArea, a.descripcion,
                prov.idProveedor, prov.nombre_empresa as nomprov FROM 
                maquinas as m 
                inner join usuarios as u on m.responsable_maquina = u.idUsuario 
		  inner join areas as a on m.idArea = a.idArea 
		  inner join proveedores as prov on m.idProveedor = prov.idProveedor 
                  inner join actividades as act on act.nombre_maquina = m.nombre_maquina                   
                 where m.status = 1";
        
        //$consulta = "SELECT * FROM maquinas as m where m.status = 1";
        //where m.status = 1 and act.idActividad not in (select idActividad from mantenimientos)";
        // and m.idMaquina not in (select idMaquina from mantenimientos)
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }    
	
    public static function getAllActives() {
        $consulta = "SELECT m.idMaquina, m.numero_maquina, m.nombre_maquina, m.responsable_maquina, m.status,
                u.apellido_paterno as apusu, u.apellido_materno as amusu, u.nombre as nomusu, a.idArea, a.descripcion,
                prov.idProveedor, prov.nombre_empresa as nomprov FROM 
                maquinas as m 
                inner join usuarios as u on m.responsable_maquina = u.idUsuario 
		  inner join areas as a on m.idArea = a.idArea 
		  inner join proveedores as prov on m.idProveedor = prov.idProveedor 
                  inner join actividades as act on act.nombre_maquina = m.nombre_maquina                   
                 where m.status = 1 order by m.nombre_maquina,m.numero_maquina";
        
        //$consulta = "SELECT * FROM maquinas as m where m.status = 1";
        //where m.status = 1 and act.idActividad not in (select idActividad from mantenimientos)";
        // and m.idMaquina not in (select idMaquina from mantenimientos)
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    } 	
    
    
    /**
     * Insertar una nueva Maquina
     *
     * @param registro a insertar
     * @return PDOStatement
     */
    public static function insert($numeroMaquina, $nombreMaquina, $idResponsable, $idArea, $status, $idProveedor, $idCategoria) {
        // Sentencia INSERT
        $comando = "INSERT INTO maquinas ( " .
            "numero_maquina," .
            "nombre_maquina," .
            "responsable_maquina ," .
            "idArea, status, idProveedor, idCategoria)" .
            " VALUES(?,?,?,?,?,?,?)";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array(
                $numeroMaquina,$nombreMaquina,$idResponsable,$idArea,$status,$idProveedor,$idCategoria
            )
        );

    }
	
    /**
     * Obtiene los campos de una Maquina con un identificador determinado
     * @param $idMaquina Identificador de la maquina
     * @return mixed
     */
    public static function getById($idMaquina) {
        $consulta = "SELECT * FROM maquinas WHERE idMaquina = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idMaquina));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idMaquina identificador y demas datos
    */
    public static function update($idMaquina,$numeroMaquina,$nombreMaquina,$idResponsable,$idArea,$status, $idProveedor, $idCategoria) {  
        $consulta = "UPDATE maquinas" .
                " SET numero_maquina=?, nombre_maquina=?, responsable_maquina=?,".
                " idArea=?, status=?, idProveedor=?, idCategoria=? " .
                "WHERE idMaquina=?";
		$cmd = Database::getInstance()->getDb()->prepare($consulta);
		$cmd->execute(array($numeroMaquina,$nombreMaquina,$idResponsable,$idArea,$status,$idProveedor,$idCategoria,$idMaquina));
        return $cmd;
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idMaquina identificador 
     */
    public static function delete($idMaquina) {
        $comando = "DELETE FROM maquinas WHERE idMaquina=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idMaquina));
    }
    
    /**   
     * Retorna en la fila especificada de la tabla 'Alumnos'
     *
     * @param $idAlumno Identificador del registro
     * @return array Datos del registro
     */
    public static function getByUser($responsable_maquina) {
        $consulta = "SELECT * from maquinas where responsable_maquina =".$responsable_maquina;
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