<?php
//configurad aquí los parámetros de la aplicación
	class Config{ 	
		
		//-----------------------------------------------------------------------------
		//EDITAR ESTOS PARAMETROS PARA CAMBIAR LA CONFIGURACION
		//URL BASE (opcional): ruta donde se encuentre el proyecto, desde el DOCUMENT_ROOT
		private $url_base = '';  //ejemplo: '/micarpeta/miproyecto/';
		
		//PARA LA BDD		
		private $db_host = 'localhost'; 	//ubicación de la BDD
		private $db_user = '';			//usuario
		private $db_pass = '';			//password
		private $db_name = '';		//nombre de la BDD
		private $db_charset = 'utf8';	//codificación a utilizar
		private $db_user_table = 'usuarios'; //nombre para la tabla de usuarios

		//CONTROLADOR Y OPERACION POR DEFECTO
		private $default_controller = 'Welcome'; //controlador por defecto
		private $default_method = 'index';		//método por defecto

		//ESTILO POR DEFECTO
		private $css = 'css/estilo.css'; //fichero CSS con el estilo por defecto
		
		//OPCIONES PARA LAS IMAGENES
		private $image_not_found = 'images/no_image.png'; //imagen no encontrada
		private $user_image_directory = 'images/users/';	//directorio para las imágenes de usuario
		private $default_user_image = 'images/users/user.png'; //imagen por defecto para usuarios
		private $user_image_max_size = 512000; //tamaño máx imágenes de usuario
		
		//-----------------------------------------------------------------------------

		
		//NO CAMBIAR A PARTIR DE ESTE PUNTO
		private static $config = null;
		
		//método público para recuperar la configuración
		public static function get(){
			if(empty(self::$config)) self::$config = new self();
			return self::$config;
		}	
		
		//getter para las propiedades (solo lectura)
		public function __get($name){
			return $this->$name;
		}		
	}	
?>
