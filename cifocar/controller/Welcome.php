<?php
	//CONTROLADOR POR DEFECTO
	//Si el controlador frontal no recibe controlador ni operación,
	//invoca por defecto el método index() del controlador Welcome
	class Welcome extends Controller{
		
		//Método por defecto
		//Carga la portada del sitio (vista welcome_message)
		public function index(){
				//preparar los datos a pasar a la vista
				$datos = array('usuario'=>Login::getUsuario());
				
				//cargar la vista
				$this->load_view('view/welcome_message.php', $datos);
		}
	}
?>