<?php

/**
 * Representa el la estructura de las Areas
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Aplicadores
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Aplicadores'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM aplicadores";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'Aplicadores'
     * @return array Datos del registro
     */
    public static function getAllWithOutMovs() {
        $consulta = "SELECT * FROM aplicadores where idAplicador not in (select idAplicador from movimientosaplicadores)";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'movimientosaplicadores'
     * @return array Datos del registro
     */
    public static function getAllMovsAplicadores() {
        $consulta = "SELECT * FROM movimientosaplicadores";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /** 
     * Obtiene los registros de movimientos por aplicador determinado
     * @return mixed
     */
    public static function getMovsByIdAplicador($idAplicador) {
        $consulta = "SELECT * FROM `movimientosaplicadores` WHERE idAplicador = ".$idAplicador." order by idMov desc";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un Aplicador con un identificador
     * determinado
     * @param $idAplicador Identificador de un aplicador
     * @return mixed
     */
    public static function getById($idAplicador) {
        $consulta = "SELECT * FROM aplicadores WHERE idAplicador = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idAplicador));
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
    public static function update($maquina,$aplicador,$fabricante,$noParteAplicador,$noParteTerminal,$noParteTerminalInterno,$cliente,$noCiclos,$idAplicador) {
        $consulta = "UPDATE aplicadores SET "
                . "noMaquina=?, "
                . "aplicador=?, "
                . "fabricante=?, "
                . "no_parte_aplicador=?, "
                . "no_parte_terminal=?, "
                . "no_parte_terminal_interno=?, "
                . "cliente=?, "
                . "no_ciclos=? "
                . "WHERE idAplicador=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($maquina,$aplicador,$fabricante,$noParteAplicador,$noParteTerminal,$noParteTerminalInterno,$cliente,$noCiclos,$idAplicador));
        return $cmd;
    }

    /**
     * Insertar un nuevo Aplicador
     * @return PDOStatement
     */
    public static function insert($maquina,$aplicador,$fabricante,$noParteAplicador,$noParteTerminal,$noParteTerminalInterno,$cliente,$noCiclos) {
        $comando = "INSERT INTO aplicadores (noMaquina,aplicador,fabricante,no_parte_aplicador,no_parte_terminal,no_parte_terminal_interno,cliente,no_ciclos) VALUES(?,?,?,?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($maquina,$aplicador,$fabricante,$noParteAplicador,$noParteTerminal,$noParteTerminalInterno,$cliente,$noCiclos)
        );
    }
    
    /**
     * Insertar un nuevo movimiento de Aplicador para iniciar tracking
     * @return PDOStatement
     */
    public static function insertMovAplicador($idAplicador,$ciclos,$idUsuario) {
        $comando = "INSERT INTO movimientosaplicadores (idAplicador,idUsuario,ciclos,tipoMovimiento) VALUES(?,?,?,'Inicio')";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($idAplicador,$idUsuario,$ciclos)
        );
    }
    

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idAplicador identificador de la tabla Aplicadores
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idAplicador) {
        $comando = "DELETE FROM aplicadores WHERE idAplicador=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idAplicador));
    }
    
}

?>