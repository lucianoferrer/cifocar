<?php
	//CLASE BASE DE LA QUE HEREDAN LOS CONTROLADORES
	//define los métodos de uso general para los controladores que hereden de ella
	//es ABSTRACTA, lo que implica que no podremos crear instancias de ella
	abstract class Controller{
		
		//método load() carga un modelo, controlador, librería o template:
		protected function load($ruta){
			if(!is_readable($ruta)) 
				throw new Exception('No se puede cargar '.$ruta);
			
			require_once($ruta); //carga el fichero
		}
		
		
		//método load_view() carga una vista:
		//data: array asociativo (u objeto) con los datos que se pasan a la vista
		protected function load_view($ruta, $data=array()){			
			//si no se encuentra el fichero con la vista...
			if(!is_readable($ruta)) 
				throw new Exception('No se encontró la vista '.$ruta);
			
			//remapear los datos del array u objeto de entrada en vars independientes
			if(is_array($data) || is_object($data))
				foreach($data as $clave=>$valor) $$clave = $valor;		
				
			require($ruta); //carga la vista	
		}
	}
?>