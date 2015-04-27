<?php 
	abstract class clsModelo_pg{ 									//Declarar clase Abstracta Modelo
	private  $db_host 	= 'localhost';									//Nombre del Host
	private  $db_usuario 	= 'postgres';										//Nombre del Usuario
	private  $db_password = '123456';											//Password de la BD.
	private  $db_num_db	 ='';
	protected $db_nombre= 'bd_venasol';				//Nombre de la Base de Datos.
	protected $query;													//Variable del Query
	protected $rows 			= array();								//Variable arreglo de las filas de una busqueda
	private $arCon;														//Variable de Conexion
	public $mensaje 			= 'Hecho';								//Mensaje de Hecho
	
	
/*-----------------------------------
* Funcion conectar (Conecta con la base de datos)
*-----------------------------------*/	   
	protected function propiedades($pcHost, $pcUsuario, $pcPassword, $pcNumdb){
		$this->db_host=$pcHost;
		$this->db_usuario=$pcUsuario;
		$this->db_password=$pcPassword;
		$this->db_num_db=$pcNumdb;
	}
/*-----------------------------------
* Funcion conectar (Conecta con la base de datos)
*-----------------------------------*/
   
	public function conectar() {
		$this->arCon = pg_connect("host=".$this->db_host." port=5432 user=".$this->db_usuario." "."password=".$this->db_password." "."dbname=".$this->db_nombre);
	}
		
/*-----------------------------------
* Funcion Desconectar (Desconecta con la base de datos)
*-----------------------------------*/
   
	public function desconectar() {
		pg_close($this->arCon);
	}
				
/*-----------------------------------
* Funcion Ejecutar (Ejecuta el Query que recibe)
*-----------------------------------*/
  
	protected function ejecutar($lcSql){
		$result=pg_query($this->arCon,$lcSql) OR die ('Ejecucion Invalida'.$lcSql);
		if (pg_affected_rows($result)==0)
		    return false;
		 return true;
	}

	protected function filtro($lcSql){
		$result=pg_query($this->arCon,$lcSql) OR die ('Ejecucion Invalida'.$lcSql);
		return $result;		
	}
			
/*-----------------------------------
* Funcion Proximo (Recorre el proximo del resultado de un arreglo)
*-----------------------------------*/
  
	protected function proximo($result){
	   $arreglo=pg_fetch_array($result);
	   return $arreglo;
	}
	
/*-----------------------------------
* Funcion Cierrafiltro (Vacia el buffer obtenido de un arreglo)
*-----------------------------------*/
  	
	protected function cierrafiltro($result){
		pg_free_result($result);
   }

/*-----------------------------------
* Funcion Begin 
*-----------------------------------*/
  	
	public function begin(){
		pg_query($this->arCon, "BEGIN");
	}
	
/*-----------------------------------
* Funcion Commit 
*-----------------------------------*/
  		
	public function commit(){
		pg_query($this->arCon,"COMMIT");
	}
		
/*-----------------------------------
* Funcion Rollback 
*-----------------------------------*/
  	
	public function rollback(){
		pg_query($this->arCon,"ROLLBACK");
	}
				
/*-----------------------------------
* Funcion Fecha Real (Convierte una fecha 'Y/m/d' a formato normal 'd/m/Y')
*-----------------------------------*/
	protected function fecha_bd($pcFecha)
  	{
  	 	return $fecha=date("Y-m-d",strtotime($pcFecha));
  	}

	protected function fechareal($fecha){
	$now="now()";
	if(strlen($fecha)==10)
	{
		$dia=substr($fecha,8,2);
		$mes=substr($fecha,5,2);
		$ano=substr($fecha,0,4);
		$now=$dia."/".$mes."/".$ano;
	}
	return $now;
	}
}
/*---------------------------------------------
*	MODELO ELABORADO CON INSTRUCCIONES 
*	PARA UNA BASE DE DATOS EN POSTGRESQL
*----------------------------------------------*/		
?>