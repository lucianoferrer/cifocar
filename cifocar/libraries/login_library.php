<?php 
	/* login_library.php
	 * 
	 * Librería para la gestión de operaciones de login-logout y el tratamiento
	 * de sesiones en el Robs Micro Framework (RMF).
	 * 
	 * Dependencias: database_library, UsuarioModel
	 * 
	 * Autor: Robert Sallent
	 * Última revisión: 04/11/2016
	 * */

	class Login{
		//-----------------------------------------------------------------------------------
		//PROPIEDADES
		//-----------------------------------------------------------------------------------
		//propiedad estática que CONTIENE EL USUARIO identificado actualmente
		private static $usuario = null;
		
		//-----------------------------------------------------------------------------------
		//METODOS
		//-----------------------------------------------------------------------------------
		//GETTER de la propiedad $usuario, devuelve el usuario identificado
		//PROTOTIPO: public UsuarioModel getUsuario();
		public static function getUsuario(){
			return self::$usuario;
		}
		
		//método que sirve para comprobar si el usuario identificado es admin
		//PROTOTIPO: public boolean isAdmin();	
		public static function isAdmin(){
			return self::$usuario && self::$usuario->admin;
		}
		
		//método que realiza la operación de login:
		//PROTOTIPO: public void log_in();
		public static function log_in($u, $p){	
			//comprueba que el usuario y password sean correctos
			if(!UsuarioModel::validar($u, $p))
				throw new Exception('Error en la identificacion');
		
			//recupera el usuario y lo guarda en la variable de sesión
			$_SESSION['user'] = serialize(UsuarioModel::getUsuario($u));					
		}
		
		//método que realiza la operación de logout
		//(se usa cuando se hace logout o se da de baja el usuario activo)
		//PROTOTIPO: public void log_out();
		public static function log_out(){
			session_unset(); 	//vacía el array $_SESSION
			session_destroy(); 	//destruye la sesión
			
			//desinstancia el usuario actual identificado
			self::$usuario = null;
			
			//elimina la cookie de sesión (reseteará el ID de sesión)
			$p = session_get_cookie_params();
			setcookie(session_name(),'',time()-1000,$p['path'],$p['domain'],$p['secure'],$p['httponly']);
		}
		
		
		//Método que gestiona las operaciones de login-logout  y almacena en la variable 
		//estática $usuario el usuario actual, ES USADO POR EL CONTROLADOR FRONTAL
		//PROTOTIPO: public static void comprobar();
		public static function comprobar(){
				
			//si piden hacer login:
			if(!empty($_POST['login'])){
				//recuperar los datos que llegan por POST
				$u = Database::get()->real_escape_string($_POST['user']); //nombre de usuario
				$p = MD5(Database::get()->real_escape_string($_POST['password'])); //password
		
				self::log_in($u,$p); //llamada al método que realiza login
			}
				
			//si piden hacer logout
			if(!empty($_POST['logout']))
				self::log_out(); //llamada al método que realiza logout
					
				
			//Pase lo que pase, recuperamos la información contenida en la variable de sesión
			//para guardarla en la propiedad estática $usuario.
			self::$usuario = empty($_SESSION['user'])? null : unserialize($_SESSION['user']);
		}
	}
?>