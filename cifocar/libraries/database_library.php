<?php
	/* database_library.php
	 *
	 * Librería para la conexión simple con la BDD para Robs Micro Framework (RMF).
	 *
	 * Dependencias: Config.php 
	 * 
	 * Autor: Robert Sallent
	 * Última revisión: 04/11/2016
	 * */


	class Database{	
	    //-----------------------------------------------------------------------------------
		//PROPIEDADES
		//-----------------------------------------------------------------------------------
		private static $conexion = null; //tipo mysqli
		
		//-----------------------------------------------------------------------------------
		//METODOS
		//-----------------------------------------------------------------------------------
		//Método que crea o recupera la conexión con la BDD
		public static function get(){			
			mysqli_report(MYSQLI_REPORT_STRICT); //notifica los Warnings como errores.
			
			//si no se había conectado antes...
			if(empty(self::$conexion)){	
				$cfg = Config::get(); //recupera la configuración del sistema
				
				//conecta con la BDD
				self::$conexion = new mysqli($cfg->db_host, $cfg->db_user, $cfg->db_pass, $cfg->db_name);
				self::$conexion->set_charset($cfg->db_charset); //establece el charset
			}
			
			return self::$conexion; //retornar la conexión
		}	
	}
?>