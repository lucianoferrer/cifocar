<?php
	//CONTROLADOR FRONTAL
	//controlador principal de la aplicación
	
	//- carga el fichero de configuración, librerías y UsuarioModel
	//- comprueba si se está haciendo login-logout
	//- despacha (gestiona) las peticiones, invocando el controlador adecuado
	
	//- en caso de que se produzcan errores, carga la vista de error.
	class FrontController extends Controller{
	
		//método principal (único método del controlador frontal)
		public function main(){
			try{
				//inicia o reanuda la sesión
				session_start(); 
							
				//PROCESO DE LOGIN
				//comprueba si me hacen login o logout y recupera el usuario activo
				Login::comprobar();
				
				//GESTION DE PETICIONES (invocar el controlador adecuado)
				//las peticiones serán en formato: 
				//index.php?controlador=Usuario&operacion=registro
				//index.php?controlador=Telefono&operacion=ver&parametro=14
				
				//recuperar el controlador solicitado que viene por GET
				//si no se indica controlador, toma el que está indicado en el 
				//fichero de configuración (Welcome)
				$controlador = empty($_GET['controlador'])? 
					Config::get()->default_controller : ucwords($_GET['controlador']);
			
				//si el controlador no existe, ERROR
				if(!is_readable('controller/'.$controlador.'.php'))
					throw new Exception('no existe el controlador '.$controlador);
				
				//si existe, lo cargamos
				$this->load('controller/'.$controlador.'.php');
					
				//recuperar la operación solicitada que viene por GET
				//si no se indica la operación, tomará la que está indicada
				//en el fichero de configuracóin (index())
				$operacion = empty($_GET['operacion'])? 
					Config::get()->default_method : $_GET['operacion'];
				
				//si no existe la operación, ERROR
				if(!is_callable(array($controlador, $operacion)))
					throw new Exception('no existe la operación '.$operacion);
				
				//recuperar el parámetro que viene por GET	
				$parametro = empty($_GET['parametro'])? '' : $_GET['parametro'];
					
				//si va todo bien, ejecutar la operación
				$c = new $controlador();
				$c->$operacion($parametro);
			
			}catch(Exception $e){
				//preparar los datos a pasar a la vista
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = $e->getMessage();
				
				//cargar la vista
				$this->load_view('view/error.php', $datos);
			}	
		}
	}
?>