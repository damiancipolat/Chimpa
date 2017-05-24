<?php

include('Config.php');

/*
  .-"-.
 /|6 6|\
{/(_0_)\}
 _/ ^ \_
(/ /^\ \)-'

PUPPYBD v1.0 por Damian Cipolat www.damiancipolat.com.ar

"Clase para el manejo de Mysql desde php."

*/


//Se declara una clase para hacer la conexion con la base de datos.
class Conexion  							
{
	var $con;
	
	function Conexion()		   	 
	{
		//Para poder usar las variables definidas en Config.php
		global $servidor_cfg,$usuario_cfg,$password_cfg,$bd_cfg;
	
		//Se definen los datos del servidor de base de datos 
		$conection['server'] = $servidor_cfg;   //Host
		$conection['user']   = $usuario_cfg;    //Usuario
		$conection['pass']   = $password_cfg;	//Password
		$conection['base']   = $bd_cfg;			//Base de datos
		
		
		//Crea la conexion pasandole el servidor , usuario y clave
		$conect= mysql_pconnect($conection['server'],$conection['user'],$conection['pass']);
			
		if ($conect) // Si la conexion fue exitosa , selecciona la base
		{
			mysql_select_db($conection['base']);			
			$this->con=$conect;
		}
	}
	
	function getConexion() //devuelve la conexion
	{
		return $this->con;
	}
	
	function Close()  	//cierra la conexion
	{
		mysql_close($this->con);
	}	
}

//Se declara una clase para poder ejecutar las consultas, esta clase llama a la clase anterior
class Query   
{
	var $pconeccion;
	var $pconsulta;
	var $resultados;
	
	function Query()  				        //Constructor, solo crea una conexion usando la clase "Conexion"
	{
		$this->pconeccion= new Conexion();
	}
	
	function executeQuery($cons)    		//Metodo que ejecuta una consulta y la guarda en el atributo $pconsulta
	{
		$this->pconsulta= mysql_query($cons,$this->pconeccion->getConexion());
		return $this->pconsulta;
	}	
	
	function getResults()   		     	//Retorna la consulta en forma de result.
	{
		return $this->pconsulta;
	}
	
	function Close()				        //Cierra la conexion
	{
		$this->pconeccion->Close();
	}	
	
	function Clean() 			         	//Libera la consulta
	{
		mysql_free_result($this->pconsulta);
	}
	
	function getResultados() 			    //Devuelve la cantidad de registros encontrados
	{
		return mysql_affected_rows($this->pconeccion->getConexion());
	}
	
	function getAffect() 			     	//Devuelve las cantidad de filas afectadas
	{
		return mysql_affected_rows($this->pconeccion->getConexion());
	}
	
	function maxId()			         	//Devuelve el maxid de la conexion, debe usarse desp de un insert, solo no!
	{
		return mysql_insert_id($this->pconeccion->getConexion());
	}
	
	function maxId_tabla($tabla)   		   //Devuelve el maxid de una tabla.
	{
		$obj  = new Query();
		$resu = $obj->executeQuery("SHOW TABLE STATUS WHERE Name = '$tabla'");

		$id  = 0;
		
		if ($row = mysql_fetch_Array($resu))
		{
			$id = trim($row['Auto_increment']);
		}
		
		if ($id==0)
		{
			return $id;
		}
		else
		{
			return $id-1;
		}			
	}
	
}


?>
