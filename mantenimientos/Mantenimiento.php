<?php

/**
 * Representa el la estructura de los Mantenimientos
 * almacenadas en la base de datos
 */
require '../db/Database.php';

class Mantenimiento
{
    function __construct()
    {
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'Mantenimientos'
     * @param $idAlumno Identificador del registro
     * @return array Datos del registro
     */
    public static function getAllSimple() {
        $consulta = "SELECT * FROM mantenimientos order by idMaquina,idResponsable";	
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Retorna en la fila especificada de la tabla 'Mantenimientos'
     * @param $idAlumno Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll() {
        $consulta = "SELECT * FROM mantenimientos as mtos inner join maquinas as maq on mtos.idMaquina = maq.idMaquina 
			inner join usuarios as u on mtos.idResponsable = u.idUsuario inner join actividades as act 
                        on mtos.idActividad = act.idActividad";	
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
	
    /**
     * Insertar una nuevo Mantenimiento
     * @param registro a insertar
     * @return PDOStatement
     */
    public static function insert($nuevosMantenimientos) {
        $conexion = mysqli_connect("localhost","root","kikinalba","CMPV1_0");
        mysqli_autocommit($conexion,FALSE);
        $mantenimientos = explode("@@@",$nuevosMantenimientos);
        $retorno;
        for ($i=0; $i<sizeof($mantenimientos)-1; $i++) {
            $partesRegMannto = explode("|",$mantenimientos[$i]);
            //if ($i == 10) {
            //    $partesRegMannto[1] = -1;
            //}
            $comando = "INSERT INTO mantenimientos ( " .
                    "fechaMantenimiento," .
                    "idResponsable," .
                    "idMaquina," .
                    "condicion_maquina ," .
                    "observaciones_maquina ," .
                    "idActividad )" .
                    " VALUES('".$partesRegMannto[0]."',".$partesRegMannto[1].",".$partesRegMannto[2].",'"
                    .$partesRegMannto[3]."','".$partesRegMannto[4]."',".$partesRegMannto[5].")";
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
     * Obtiene los campos de un Mantenimiento con un identificador
     * determinado
     * @param $idFechaMantenimiento Identificador del alumno
     * @return mixed
     */
    public static function getById($idFechaMantenimiento) {
        // Consulta de la tabla Alumnos
        $consulta = "SELECT * FROM mantenimientos as mantto inner join actividades as act "
                . "on mantto.idActividad = act.idActividad WHERE idFechaMantenimiento = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idFechaMantenimiento));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**  
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idFechaMantenimiento identificador
     */
    public static function update($idResponsable, $idFechaMantenimiento, $fechaMantenimiento, $condicion_maquina,$observaciones_maquina) {  
        $dt = new DateTime("now", new DateTimeZone('America/Mexico_City'));
        $fechaIngreso = $dt->format("Y-m-d H:i:s"); 
        $consulta;
        if ($condicion_maquina == "ATENDIDA"){
//            $consulta = "UPDATE mantenimientos" .
//                    " SET fechaMantenimiento=concat(trim(substr(fechaMantenimiento,1,9)),' ','".$fechaIngreso."'), condicion_maquina=?, observaciones_maquina=? " .
//                    "WHERE idFechaMantenimiento=?";
            $consulta = "UPDATE mantenimientos" .
                    " SET condicion_maquina=?, observaciones_maquina=? " .
                    "WHERE idFechaMantenimiento=?";
        } else {
//            $consulta = "UPDATE mantenimientos" .
//                    " SET fechaMantenimiento=trim(substr(fechaMantenimiento,1,9)),condicion_maquina=?, observaciones_maquina=? " .
//                    "WHERE idFechaMantenimiento=?";
            $consulta = "UPDATE mantenimientos" .
                    " SET observaciones_maquina=? " .
                    "WHERE idFechaMantenimiento=?";
        }
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        //$cmd->execute(array($condicion_maquina,$observaciones_maquina,$idFechaMantenimiento));
        $cmd->execute(array($observaciones_maquina,$idFechaMantenimiento));
        return $cmd;
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idFechaMantenimiento identificador de la tabla mantenimientos
     * @return bool Respuesta de la eliminaci�n
     */
    public static function delete($idFechaMantenimiento) {
        $comando = "DELETE FROM mantenimientos WHERE idFechaMantenimiento=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idFechaMantenimiento));
    }
    
    /** 
     * Obtiene los campos de un Mantenimiento por semana y usuario con un 
     * identificador determinado
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function getByWeekUser($idUsuario,$week) {
        $weeks = explode("|",$week);
        $consulta = "";
        if (sizeof($weeks) > 1) {
            if ($weeks[1] != "") {
                //echo "---------> AAAAAAAAAAAAAAAAAAAAAAAAAAAAA".$weeks[0]." and ".$weeks[1];
                $consulta = "select * from mantenimientos as manttos inner join maquinas "
                        . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                        . "as act on act.idActividad = manttos.idActividad where manttos.idResponsable = '".$idUsuario."'"
                        . "and TRIM(SUBSTRING(manttos.fechaMantenimiento, 8, 2)) BETWEEN "
                        .$weeks[0]." and ".$weeks[1];
            } else {
                $semana = "Semana ". trim($weeks[0]);
//                $consulta = "SELECT mantos.idFechaMantenimiento,mantos.fechaMantenimiento,maq.idMaquina,maq.nombre_maquina,act.descripcion_actividad"
//                    . ",mantos.condicion_maquina,mantos.observaciones_maquina FROM `maquinas` as maq inner join mantenimientos "
//                    ."as mantos on maq.responsable_maquina = mantos.idResponsable "
//                    ."inner join actividades as act on act.idActividad = "
//                    ."mantos.idActividad where mantos.idResponsable=".$idUsuario." and " 
//                    ."TRIM(SUBSTRING(mantos.fechaMantenimiento, 1, 9)) = "
//                    ."'".$semana."'"; 
                $consulta = "SELECT mantenimientos.idFechaMantenimiento,mantenimientos.fechaMantenimiento,"
                        ."maquinas.nombre_maquina,maquinas.numero_maquina,maquinas.idMaquina,actividades.descripcion_actividad"
                        .",mantenimientos.condicion_maquina,mantenimientos.observaciones_maquina FROM `mantenimientos` "
                        ."inner join maquinas on mantenimientos.idResponsable = maquinas.responsable_maquina "
                        ."INNER JOIN actividades on actividades.idActividad = mantenimientos.idActividad where "
                        ."mantenimientos.idResponsable=".$idUsuario." and TRIM(SUBSTRING(mantenimientos.fechaMantenimiento, 1, 9))='".$semana."' and mantenimientos.condicion_maquina ='NO ATENDIDA'";
                //echo $consulta;
            }
        } else {
            $semana = "Semana ". trim($weeks[0]);
            //echo "--------->  ".$semana;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                    . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                    . "as act on act.idActividad = manttos.idActividad where manttos.idResponsable = '".$idUsuario."'"
                    . "and TRIM(SUBSTRING(manttos.fechaMantenimiento, 1, 9)) = '".$semana."'";  
            //echo $consulta;
        } 
        
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /** 
     * Obtiene los campos de un Mantenimiento por semana y usuario con un 
     * identificador determinado
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function getByWeekUser2($idUsuario,$week) {
        $weeks = explode("|",$week);
        $consulta = "";
        if (sizeof($weeks) > 1) {
            if ($weeks[1] != "") {
                $consulta = "select * from mantenimientos as manttos inner join maquinas "
                        . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                        . "as act on act.idActividad = manttos.idActividad where manttos.idResponsable = '".$idUsuario."'"
                        . "and TRIM(SUBSTRING(manttos.fechaMantenimiento, 8, 2)) BETWEEN "
                        .$weeks[0]." and ".$weeks[1];
            } else {
                $semana = "Semana ". trim($weeks[0]);
                $consulta = "select * from mantenimientos where TRIM(SUBSTRING(fechaMantenimiento, 1, 9))='".$semana."' and `idResponsable`=".$idUsuario;
            }
        } else {
            $semana = "Semana ". trim($weeks[0]);
            //echo "--------->  ".$semana;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                    . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                    . "as act on act.idActividad = manttos.idActividad where manttos.idResponsable = '".$idUsuario."'"
                    . "and TRIM(SUBSTRING(manttos.fechaMantenimiento, 1, 9)) = '".$semana."'";  
            //echo $consulta;
        } 
        
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un Mantenimiento con un identificador
     * determinado y su actividad
     * @param $idFechaMantenimiento Identificador del alumno
     * @return mixed
     */
    public static function getByIdMantenimiento($idFechaMantenimiento) {
        $consulta = "SELECT * FROM mantenimientos as manttos inner join actividades as "
                . "acts on manttos.idActividad = acts.idActividad WHERE idFechaMantenimiento = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idFechaMantenimiento));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idFechaMantenimiento identificador
     * @param mas campos     
     */
    public static function updateByTecnico($idFechaMantenimiento,$fechaMantenimiento,$observaciones_maquina, $rutaImagen) { 
        $condicion_maquina = "ATENDIDA";
        $dt = new DateTime("now", new DateTimeZone('America/Mexico_City'));
        $fechaMantto = $dt->format("Y-m-d H:i:s");         
        $fechaMantenimiento = $fechaMantenimiento." ".$fechaMantto;
        $consulta = "UPDATE mantenimientos" .
                " SET fechaMantenimiento=?, ".
                " condicion_maquina=?, observaciones_maquina=?, urlImagen=? " .
                "WHERE idFechaMantenimiento=?";
		$cmd = Database::getInstance()->getDb()->prepare($consulta);
		$cmd->execute(array($fechaMantenimiento, $condicion_maquina, $observaciones_maquina, $rutaImagen, $idFechaMantenimiento));
        return $cmd;
    }
    
    /** 
     * Obtiene los campos de un Mantenimiento por semana y usuario con un 
     * identificador determinado
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function getQueryPersonalized($parametrosConsulta) {
        //$idMaquina."|".$numero_maquina."|".$idActividad."|".$idResponsable."|".$week1."|".$week2."|";
        $partesConsulta = explode("|",$parametrosConsulta);
        $consulta = "";
        $idMaq = $partesConsulta[0];
        $numMaq = $partesConsulta[1];
        $idAct = $partesConsulta[2];
        $idResp = $partesConsulta[3];
        $sem1 = $partesConsulta[4];
        $sem2 = $partesConsulta[5];
        $combinacionesConsultas = 0;
        
        //caso 1.- todos los campos vienen vacios
        if (($idMaq == "") && ($numMaq == "") && ($idAct == "") 
                && ($idResp == "") && ($sem1 == "") && ($sem2 == "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable";
        }

         //caso 2.- Viene el idMaquina
        if (($idMaq != "") && ($numMaq == "") && ($idAct == "") 
                && ($idResp == "") && ($sem1 == "") && ($sem2 == "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable "
                . "where manttos.idMaquina = '".$idMaq."'";   
        }
        
         //caso 3.- Viene el idMaquina y el numMaq
        if (($idMaq != "") && ($numMaq != "") && ($idAct == "") 
                && ($idResp == "") && ($sem1 == "") && ($sem2 == "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable "
                . "where manttos.idMaquina = '".$idMaq."' and m.numero_maquina = '".$numMaq."'";   
        }

         //caso 4.- Viene el idMaquina, numMaq, idActividad
        if (($idMaq != "") && ($numMaq != "") && ($idAct != "") 
                && ($idResp == "") && ($sem1 == "") && ($sem2 == "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable "
                . "where manttos.idMaquina = '".$idMaq."' and m.numero_maquina = '".$numMaq."' and "
                . "manttos.idActividad = '".$idAct."'";    
        }

         //caso 5.- Viene el idMaquina, numMaq, idActividad, idResp
        if (($idMaq != "") && ($numMaq != "") && ($idAct != "") 
                && ($idResp != "") && ($sem1 == "") && ($sem2 == "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable "
                . "where manttos.idMaquina = '".$idMaq."' and m.numero_maquina = '".$numMaq."' and "
                . "manttos.idActividad = '".$idAct."' and m.responsable_maquina = '".$idResp."'";    
        }

         //caso 6.- Viene el idMaquina, numMaq, idActividad, idResp, sem1
        if (($idMaq != "") && ($numMaq != "") && ($idAct != "") 
                && ($idResp != "") && ($sem1 != "") && ($sem2 == "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable "
                . "where manttos.idMaquina = '".$idMaq."' and m.numero_maquina = '".$numMaq."' and "
                . "manttos.idActividad = '".$idAct."' and m.responsable_maquina = '".$idResp."' and "
                . "TRIM(SUBSTRING(manttos.fechaMantenimiento, 8, 2)) = '".$sem1."'";
        }
        
         //caso 7.- Viene el idMaquina, numMaq, idActividad, idResp, sem1, sem2
        if (($idMaq != "") && ($numMaq != "") && ($idAct != "") 
                && ($idResp != "") && ($sem1 != "") && ($sem2 != "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable "
                . "where manttos.idMaquina = '".$idMaq."' and m.numero_maquina = '".$numMaq."' and "
                . "manttos.idActividad = '".$idAct."' and m.responsable_maquina = '".$idResp."' and "
                . "TRIM(SUBSTRING(manttos.fechaMantenimiento, 8, 2)) BETWEEN ".$sem1." and ".$sem2;
        }      
        
         //caso 8.- sem1
        if (($idMaq == "") && ($numMaq == "") && ($idAct == "") 
                && ($idResp == "") && ($sem1 != "") && ($sem2 == "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable "
                . "where "
                . "TRIM(SUBSTRING(manttos.fechaMantenimiento, 8, 2)) = '".$sem1."'";
        }              
        
         //caso 9.- sem1, sem2
        if (($idMaq == "") && ($numMaq == "") && ($idAct == "") 
                && ($idResp == "") && ($sem1 != "") && ($sem2 != "")) {
            $combinacionesConsultas = 1;
            $consulta = "select * from mantenimientos as manttos inner join maquinas "
                . "as m on manttos.idMaquina = m.idMaquina inner join actividades "
                . "as act on act.idActividad = manttos.idActividad "
                . "inner join usuarios as u on u.idUsuario = manttos.idResponsable "
                . "where "
                . "TRIM(SUBSTRING(manttos.fechaMantenimiento, 8, 2)) BETWEEN ".$sem1." and ".$sem2;
        }           
        //faltan mas combinaciones
        
        //ejecucion de la consulta
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }    
    
    
    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idFechaMantenimiento identificador
     * @param mas campos     
     */
    public static function updateVerificacion($idFechaMantenimiento,$accion) { 
        $consulta = "UPDATE mantenimientos SET verificada=? WHERE idFechaMantenimiento=?";
	$cmd = Database::getInstance()->getDb()->prepare($consulta);
	$cmd->execute(array($accion, $idFechaMantenimiento));
        return $cmd;
    }

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idMaquina identificador de la tabla mantenimientos
     * @return bool Respuesta de la eliminacion
     */
    public static function deleteMantoMasivo($idMaqElim,$idRespElim) {
        $comando = "DELETE FROM mantenimientos WHERE idMaquina=? and idResponsable=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($idMaqElim,$idRespElim));
    }
    
    /**  
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     * @param $idMaquina,$idResponsable identificador
     * @param mas campos     
     */
    public static function updateCambioResponsableMasivo($idMaquina,$idResponsable,$idResponsableNuevo) {  
        $consulta = "UPDATE mantenimientos" .
                " SET idResponsable=? where idMaquina=? and idResponsable=?";
		$cmd = Database::getInstance()->getDb()->prepare($consulta);
		$cmd->execute(array($idResponsableNuevo,$idMaquina,$idResponsable));
        return $cmd;
    }
    
    
    /** 
     * Obtiene los campos de un Mantenimiento por semana y usuario con un 
     * identificador determinado
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function obtenerMantenimientosConsulta($idResponsable,$week,$idMaquina) {
        $weeks = explode("|",$week);
        $consulta = "";
        
        //solo prueba
        //$weeks[0] = 100;
        //$weeks[1] = 101;

        if ($idMaquina == 0){ // si viene la maquina/responsable vacia
            if ($idResponsable == 0){ // si viene el reponsable en blanco la consulta es normal por fechas
                if (sizeof($weeks) > 1) {
                    if ($weeks[1] != "") { //si vienen las dos fechas
                        //consulta entre semanan
                        $consulta = "select * from mantenimientos where "
                                . "TRIM(SUBSTRING(fechaMantenimiento, 8, 2)) BETWEEN "
                                .$weeks[0]." and ".$weeks[1];
                    } else { //si solo viene una fecha
                        //inicio de las consultas por aqui se viene mantenimiento por semana vigente
                        $semana = "Semana ". trim($weeks[0]);
                        $consulta = "select * from mantenimientos where TRIM(SUBSTRING(fechaMantenimiento, 1, 9))='".$semana."'";
                    }
                } else {
                    //consulta por semana actual es la consulta por defecto
                    $semana = "Semana ". trim($weeks[0]);
    //                $consulta = "select * from mantenimientos where TRIM(SUBSTRING(manttos.fechaMantenimiento, 1, 9)) = '".$semana."'";  
                    $consulta = "select * from mantenimientos";  
                } 
            } else {
                if ($weeks[1] != "") { //consulta con dos semanan con idResponsable
                    $consulta = "select * from mantenimientos where idResponsable=".$idResponsable." and "
                            . "TRIM(SUBSTRING(fechaMantenimiento, 8, 2)) BETWEEN "
                            .$weeks[0]." and ".$weeks[1];
                } else { 
                    if ($weeks[0] != "") { //inicio de las consultas por aqui se viene mantenimiento por semana elegida
                        $semana = "Semana ". trim($weeks[0]);
                        $consulta = "select * from mantenimientos where idResponsable=".$idResponsable." and "
                                ."TRIM(SUBSTRING(fechaMantenimiento, 1, 9))='".$semana."'";
                    } else { //consulta por idResponsable sin semana especifica
                        $semana = "Semana ". trim($weeks[0]);
                        $consulta = "select * from mantenimientos where idResponsable=".$idResponsable;  
                    }
                }
            }
        } else { //si viene una maquina de ahi se toma al responsable
            if ($weeks[1] != "") { //consulta con dos semanan con idResponsable
                $consulta = "select * from mantenimientos where idMaquina=".$idMaquina." and "
                        . "TRIM(SUBSTRING(fechaMantenimiento, 8, 2)) BETWEEN "
                        .$weeks[0]." and ".$weeks[1];
            } else { 
                if ($weeks[0] != "") { //inicio de las consultas por aqui se viene mantenimiento por semana elegida
                    $semana = "Semana ". trim($weeks[0]);
                    $consulta = "select * from mantenimientos where idMaquina=".$idMaquina." and "
                            ."TRIM(SUBSTRING(fechaMantenimiento, 1, 9))='".$semana."'";
                } else { //consulta por idResponsable sin semana especifica
                    $semana = "Semana ". trim($weeks[0]);
                    $consulta = "select * from mantenimientos where idMaquina=".$idMaquina;  
                }
            }
        }
        
        $consulta = $consulta." ORDER BY TRIM(SUBSTRING(fechaMantenimiento, 1, 9)) ASC";
        
        
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /** 
     * Obtiene los campos de un Mantenimiento por semana y usuario con un 
     * identificador determinado
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function obtenerMantenimientosConsultaHistorico($idResponsable,$week,$idMaquina,$tabla) {
        $weeks = explode("|",$week);
        $consulta = "";
        
        //solo prueba
        //$weeks[0] = 100;
        //$weeks[1] = 101;

        if ($idMaquina == 0){ // si viene la maquina/responsable vacia
            if ($idResponsable == 0){ // si viene el reponsable en blanco la consulta es normal por fechas
                if (sizeof($weeks) > 1) {
                    if ($weeks[1] != "") { //si vienen las dos fechas
                        //consulta entre semanan
                        $consulta = "select * from ".$tabla." where "
                                . "TRIM(SUBSTRING(fechaMantenimiento, 8, 2)) BETWEEN "
                                .$weeks[0]." and ".$weeks[1];
                    } else { //si solo viene una fecha
                        //inicio de las consultas por aqui se viene mantenimiento por semana vigente
                        $semana = "Semana ". trim($weeks[0]);
                        $consulta = "select * from ".$tabla." where TRIM(SUBSTRING(fechaMantenimiento, 1, 9))='".$semana."'";
                    }
                } else {
                    //consulta por semana actual es la consulta por defecto
                    $semana = "Semana ". trim($weeks[0]);
    //                $consulta = "select * from mantenimientos where TRIM(SUBSTRING(manttos.fechaMantenimiento, 1, 9)) = '".$semana."'";  
                    $consulta = "select * from ".$tabla;  
                } 
            } else {
                if ($weeks[1] != "") { //consulta con dos semanan con idResponsable
                    $consulta = "select * from ".$tabla." where idResponsable=".$idResponsable." and "
                            . "TRIM(SUBSTRING(fechaMantenimiento, 8, 2)) BETWEEN "
                            .$weeks[0]." and ".$weeks[1];
                } else { 
                    if ($weeks[0] != "") { //inicio de las consultas por aqui se viene mantenimiento por semana elegida
                        $semana = "Semana ". trim($weeks[0]);
                        $consulta = "select * from ".$tabla." where idResponsable=".$idResponsable." and "
                                ."TRIM(SUBSTRING(fechaMantenimiento, 1, 9))='".$semana."'";
                    } else { //consulta por idResponsable sin semana especifica
                        $semana = "Semana ". trim($weeks[0]);
                        $consulta = "select * from ".$tabla." where idResponsable=".$idResponsable;  
                    }
                }
            }
        } else { //si viene una maquina de ahi se toma al responsable
            if ($weeks[1] != "") { //consulta con dos semanan con idResponsable
                $consulta = "select * from ".$tabla." where idMaquina=".$idMaquina." and "
                        . "TRIM(SUBSTRING(fechaMantenimiento, 8, 2)) BETWEEN "
                        .$weeks[0]." and ".$weeks[1];
            } else { 
                if ($weeks[0] != "") { //inicio de las consultas por aqui se viene mantenimiento por semana elegida
                    $semana = "Semana ". trim($weeks[0]);
                    $consulta = "select * from ".$tabla." where idMaquina=".$idMaquina." and "
                            ."TRIM(SUBSTRING(fechaMantenimiento, 1, 9))='".$semana."'";
                } else { //consulta por idResponsable sin semana especifica
                    $semana = "Semana ". trim($weeks[0]);
                    $consulta = "select * from ".$tabla." where idMaquina=".$idMaquina;  
                }
            }
        }
        
        
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
  
    /** 
     * Obtiene los campos de un Mantenimiento por idMaquina
     * @return mixed
     */
    public static function getByidMaquina($idMaquina) {
		//antes
        $consulta = "select * from mantenimientos where idMaquina = ".$idMaquina;
		//arreglo temporal
        //$consulta = "select * from mantenimientos where idMaquina = ".$idMaquina." order by idFechaMantenimiento desc";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /** 
     * Obtiene los campos de un Mantenimiento por idMaquina y semanas
     * @return mixed
     */
    public static function getByidMaquinaSemanas($idMaquina,$semana1,$semana2) {
        //$consulta = "select * from mantenimientos where idMaquina = ".$idMaquina;
        $consulta = "select * from mantenimientos where "
                . "TRIM(SUBSTRING(fechaMantenimiento, 8, 2)) BETWEEN "
                .$semana1." and ".$semana2." and idMaquina = ".$idMaquina;
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