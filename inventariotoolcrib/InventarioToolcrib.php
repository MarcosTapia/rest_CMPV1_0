<?php

/**
 * Representa el la estructura del inventario Toolcrib
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class InventarioToolcrib
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'inventarios_toolcrib'
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM inventarios_toolcrib as inv inner join proveedores"
                . " on proveedores.idProveedor =  inv.idProveedor";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'movimientosinventario'
     * @return array Datos del registro
     */
    public static function getAllMovs() {
        $consulta = "SELECT * FROM movimientosinventario as mov_inv inner join maquinas"
                . " on maquinas.idMaquina=mov_inv.idMaquina inner join usuarios"
                . " on usuarios.idUsuario =  mov_inv.idUsuario inner join inventarios_toolcrib as invtool"
                . " on invtool.idInventario = mov_inv.idInventario order by idMov desc";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /** 
     * Obtiene los registros de movimientos por noparte determinada
     * @return mixed
     */
    public static function getMovsByIdInventario($idInventario) {
        //$consulta = "SELECT * FROM `movimientosinventario` as movs inner join inventarios_toolcrib as inv on movs.idInventario = inv.idInventario WHERE movs.idInventario = ".$idInventario." order by idMov desc";
        $consulta = "SELECT * FROM `movimientosinventario` WHERE idInventario = ".$idInventario." order by idMov desc";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    

    /**
     * Obtiene los campos de una parte con un identificador
     * determinado
     * @param $idInventario Identificador
     * @return mixed
     */
    public static function getById($idInventario) {
        $consulta = "SELECT * FROM inventarios_toolcrib WHERE idInventario = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idInventario));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Obtiene los campos de una parte con un identificador
     * determinado
     * @param $numero_parte Identificador
     * @return mixed
     */
    public static function getByPartNumber($numero_parte) {
        $consulta = "SELECT * FROM inventarios_toolcrib WHERE numero_parte = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($numero_parte));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }
    

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idInventario  identificador
     */
    public static function update($idInventario,$numSAP,$maquina,$descripcion,$numParte,$ubicacion,$stock,$minimo,$maximo,$idProveedor,$idUsuario,$cantidad) {  
        $servername = "localhost";
        $username = "root";
        $password = "kikinalba";
        $dbname = "cmpv1_0";
        $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        } 
        $consulta = "UPDATE inventarios_toolcrib" .
            " SET sap=?, maquina=?, descripcion=?, numero_parte=?, ".
            " ubicacion=?, stock=?, cantidad_minima=?, cantidad_maxima=?, idProveedor=?" .
            "WHERE idInventario=?;";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($numSAP,$maquina,$descripcion,$numParte,$ubicacion,$stock,$minimo,$maximo,$idProveedor,$idInventario));
        //return $cmd;
        
        //llamada al store
        $result = mysqli_query($conn, "CALL trackUserOperations(".$idUsuario.",".$idInventario.",".$cantidad.",589,'".$maquina."')");
        return $result;
    }

    /**
     * Insertar un nuevo numero de parte
     * @return PDOStatement
     */
    public static function insert($numSAP,$maquina,$descripcion,$numParte,$ubicacion,$stock,$minimo,$maximo,$idProveedor) {
        $comando = "INSERT INTO inventarios_toolcrib ( " .
            "sap," .
            "maquina," .
            "descripcion," .
            "numero_parte," .
            "ubicacion," .
            "stock," .
            "cantidad_minima," .
            "cantidad_maxima," .
            "idProveedor)" .
            " VALUES( ?,?,?,?,?,?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($numSAP,$maquina,$descripcion,$numParte,$ubicacion,$stock,$minimo,$maximo,$idProveedor)
        );
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idInventario identificador de la tabla Proveedores
     * @return bool Respuesta de la eliminaci�n
     */
    public static function delete($idInventario) {
        $comando = "DELETE FROM inventarios_toolcrib WHERE idInventario=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idInventario));
    }
    
    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idInventario  identificador
     */
    public static function updateQR($idUsuario,$idInventario,$cantidad,$idMaquina,$stock){
        $servername = "localhost";
        $username = "root";
        $password = "kikinalba";
        $dbname = "cmpv1_0";
        $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }        
        $consulta = "UPDATE inventarios_toolcrib" .
            " SET stock=?" .
            "WHERE idInventario=?";
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($stock,$idInventario));
        
        //llamada al store
        $result = mysqli_query($conn, "CALL trackUserOperations(".$idUsuario.",".$idInventario.",".$cantidad.",".$idMaquina.",'')");
        return $result;
    }
    
   /**
     * Retorna en la fila especificada de la tabla 'inventarios_toolcrib'
     * de las partes que haga falta por surtir
     * @return array Datos del registro
     */
    public static function getAllAlerts() {
        $consulta = "SELECT * FROM inventarios_toolcrib as inv inner join proveedores as p "
                . "on inv.idProveedor = p.idProveedor where "
                . "inv.stock < inv.cantidad_minima order by inv.idProveedor";
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