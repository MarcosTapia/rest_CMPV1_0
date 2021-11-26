<?php

/**
 * Representa el la estructura de los Datos del Sistema
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Sistema
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'sistema'
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM sistema";
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
     *
     * @param $idEmpresa Identificador de la empresa
     * @return mixed
     */
    public static function getById($idSistema)
    {
        // Consulta de la tabla sistema
        $consulta = "SELECT *
                             FROM sistema
                             WHERE idSistema = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idSistema));
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
     *
     * @param $idSistema      identificador etc, etc
     */
    public static function update($idSistema,$ivaEmpresa,$historicoProveedores,
        $criterioHistoricoProveedores,$camposInventario,$camposVentas,
        $camposCompras,$camposConsultas,$camposProveedores,$camposClientes,
        $camposEmpleados,$camposEmpresa,$ivaGral) {  
        
        // Creando consulta UPDATE
        $consulta = "UPDATE sistema" .
            " SET ivaEmpresa=?, historicoProveedores=?, criterioHistoricoProveedores=?, camposInventario=?,".
            " camposVentas=?, camposCompras=?, camposConsultas=?, camposProveedores=?, " .
            " camposClientes=?, camposEmpleados=?, camposEmpresa=?, ivaGral=? " .
            "WHERE idSistema=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
            $cmd->execute(array(
            $ivaEmpresa,
            $historicoProveedores,
            $criterioHistoricoProveedores,
            $camposInventario,
            $camposVentas,
            $camposCompras,
            $camposConsultas,
            $camposProveedores,
            $camposClientes,
            $camposEmpleados,
            $camposEmpresa,
            $ivaGral,
            $idSistema)
            );

        return $cmd;
    }

}

?>