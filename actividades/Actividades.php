<?php

/**
 * Representa el la estructura de las Actividades
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Actividades
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Actividades'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM actividades order by nombre_maquina";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Insertar varias Actividades mediante una transaccion
     *
     * @param registro a insertar
     * @return PDOStatement
     */
    public static function insert($actividadesGlobal) {
        $conexion = mysqli_connect("localhost","root","kikinalba","CMPV1_0");
        mysqli_autocommit($conexion,FALSE);
        $actividadesGlobal = explode("@@@",$actividadesGlobal);
        $retorno;
        for ($i=0;$i<sizeof($actividadesGlobal) - 1;$i++) {
            $actividades = explode("|",$actividadesGlobal[$i]);
            $comando = "INSERT INTO actividades ( " .
                    "descripcion_actividad," .
                    "frecuencia," .
                    "nombre_maquina)" .
                    " VALUES('".$actividades[0]."','".$actividades[1]."','".$actividades[2]."')";
            $retorno = mysqli_query($conexion,$comando);
            if ($retorno == FALSE) {
                mysqli_rollback($conexion);
                break;
            }            
        }
        if ($retorno != FALSE) {
            mysqli_autocommit($conexion,TRUE);
            $retorno = true;
        }        
        return $retorno;
    }
	
    /**
     * Obtiene los campos de una Actividad con un identificador determinado
     * @param $idMaquina Identificador de la maquina
     * @return mixed
     */
    public static function getById($idActividad) {
        $consulta = "SELECT * FROM actividades WHERE idActividad = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idActividad));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idActividad identificador y demas datos
    */
    public static function update($idActividad,$descripcion_actividad,$frecuencia,$nombre_maquina) {  
        $consulta = "UPDATE actividades" .
                " SET descripcion_actividad=?, frecuencia=?, nombre_maquina=? " .
                "WHERE idActividad=?";
		$cmd = Database::getInstance()->getDb()->prepare($consulta);
		$cmd->execute(array($descripcion_actividad,$frecuencia,$nombre_maquina,$idActividad));
        return $cmd;
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idActividad identificador 
     */
    public static function delete($idActividad) {
        $comando = "DELETE FROM actividades WHERE idActividad=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idActividad));
    }
    
}

?>