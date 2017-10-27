<?php
	//CONTROLADOR USUARIO 
	// implementa las operaciones que puede realizar el usuario
	class Usuario extends Controller{

		//PROCEDIMIENTO PARA REGISTRAR UN USUARIO
		public function registro(){

			//si no llegan los datos a guardar
			if(empty($_POST['guardar'])){
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['max_image_size'] = Config::get()->user_image_max_size;
				$this->load_view('view/usuarios/registro.php', $datos);
			
			//si llegan los datos por POST
			}else{
			    //crear una instancia de Usuario
				$u = new UsuarioModel();
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$u->user = $conexion->real_escape_string($_POST['user']);
				$u->password = MD5($conexion->real_escape_string($_POST['password']));
				$u->nombre = $conexion->real_escape_string($_POST['nombre']);
				$u->privilegio = intval($_POST['privilegio']);
				$u->email = $conexion->real_escape_string($_POST['email']);
				$u->imagen = Config::get()->default_user_image;
				$u->admin= !empty($_POST['admin'])?0:1 ;//si esta vacio como es null guarda 0 y si tiene valor como es true guarad 1 
				
				//recuperar y guardar la imagen (solamente si ha sido enviada)
				if($_FILES['imagen']['error']!=4){
					//el directorio y el tam_maximo se configuran en el fichero config.php
					$dir = Config::get()->user_image_directory;
					$tam = Config::get()->user_image_max_size;
					
					$upload = new Upload($_FILES['imagen'], $dir, $tam);
					$u->imagen = $upload->upload_image();
				}
								
				//guardar el usuario en BDD
				if(!$u->guardar())
					throw new Exception('No se pudo registrar el usuario');
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Operación de registro completada con éxito';
				$this->load_view('view/exito.php', $datos);
			}
		}
		

		//PROCEDIMIENTO PARA MODIFICAR UN USUARIO
		public function modificacion(){
			//si no hay usuario identificado... error
			if(!Login::getUsuario())
				throw new Exception('Debes estar identificado para poder modificar tus datos');
				
			//si no llegan los datos a modificar
			if(empty($_POST['modificar'])){
				
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['max_image_size'] = Config::get()->user_image_max_size;
				$this->load_view('view/usuarios/modificacion.php', $datos);
					
				//si llegan los datos por POST
			}else{
				//recuperar los datos actuales del usuario
				$u = Login::getUsuario();
				$conexion = Database::get();
				
				//comprueba que el usuario se valide correctamente
				$p = MD5($conexion->real_escape_string($_POST['password']));
				if($u->password != $p)
					throw new Exception('El password no coincide, no se puede procesar la modificación');
								
				//recupera el nuevo password (si se desea cambiar)
				if(!empty($_POST['newpassword']))
					$u->password = MD5($conexion->real_escape_string($_POST['newpassword']));
				
				//recupera el nuevo nombre y el nuevo email
				$u->nombre = $conexion->real_escape_string($_POST['nombre']);
				$u->email = $conexion->real_escape_string($_POST['email']);
						
				//TRATAMIENTO DE LA NUEVA IMAGEN DE PERFIL (si se indicó)
				if($_FILES['imagen']['error']!=4){
					//el directorio y el tam_maximo se configuran en el fichero config.php
					$dir = Config::get()->user_image_directory;
					$tam = Config::get()->user_image_max_size;
					
					//prepara la carga de nueva imagen
					$upload = new Upload($_FILES['imagen'], $dir, $tam);
					
					//guarda la imagen antigua en una var para borrarla 
					//después si todo ha funcionado correctamente
					$old_img = $u->imagen;
					
					//sube la nueva imagen
					$u->imagen = $upload->upload_image();
				}
				
				//modificar el usuario en BDD
				if(!$u->actualizar())
					throw new Exception('No se pudo modificar');
		
				//borrado de la imagen antigua (si se cambió)
				//hay que evitar que se borre la imagen por defecto
				if(!empty($old_img) && $old_img!= Config::get()->default_user_image)
					@unlink($old_img);
						
				//hace de nuevo "login" para actualizar los datos del usuario
				//desde la BDD a la variable de sesión.
				Login::log_in($u->user, $u->password);
					
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Modificación OK';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		//PROCEDIMIENTO PARA LISTAR LOS USUARIOS
		public function listar($pagina){
		    $this->load('model/UsuarioModel.php');
		    
		    //si me piden APLICAR un filtro
		    if(!empty($_POST['filtrar'])){
		        //recupera el filtro a aplicar
		        $f = new stdClass(); //filtro
		        $f->texto = htmlspecialchars($_POST['texto']);
		        $f->campo = htmlspecialchars($_POST['campo']);
		        $f->campoOrden = htmlspecialchars($_POST['campoOrden']);
		        $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
		        
		        //guarda el filtro en un var de sesión
		        $_SESSION['filtroUsuario'] = serialize($f);
		    }
		    
		    //si me piden QUITAR un filtro
		    if(!empty($_POST['quitarFiltro']))
		        unset($_SESSION['filtroUsuario']);
		        
		        
		        //comprobar si hay filtro
		        $filtro = empty($_SESSION['filtroUsuario'])? false : unserialize($_SESSION['filtroUsuario']);
		        //para la paginación
		        $num = 10; //numero de resultados por página
		        $pagina = abs(intval($pagina)); //para evitar cosas raras por url
		        $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
		        $offset = $num*($pagina-1); //offset
		        
		        //si no hay que filtrar los resultados...
		        if(!$filtro){
		            //recupera todos los usuarios
		            $usuario = UsuarioModel::getUsuarios($num, $offset);
		            //total de registros (para paginación)
		            $totalRegistros = UsuarioModel::getTotal();
		        }else{
		            //recupera los usuarios con el filtro aplicado
		            $usuario = UsuarioModel::getUsuarios($num, $offset, $filtro->texto, $filtro->campo, $filtro->campoOrden, $filtro->sentidoOrden);
		            //total de registros (para paginación)
		            $totalRegistros = UsuarioModel::getTotal($filtro->texto, $filtro->campo);
		        }
		        
		        //cargar la vista del listado
		        $datos = array();
		        $datos['usuario'] = Login::getUsuario();
		        $datos['usuarios'] = $usuario;
		        $datos['filtro'] = $filtro;
		        $datos['paginaActual'] = $pagina;
		        $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
		        $datos['totalRegistros'] = $totalRegistros;
		        $datos['regPorPagina'] = $num;
		        
		        if(!Login::isAdmin())
		            throw new Exception('Debes ser administrador');
	            $this->load_view('view/usuarios/lista_admin.php', $datos);
// 		            else
// 		                $this->load_view('view/usuarios/lista.php', $datos);
		}
		
		
		//PROCEDIMIENTO PARA DAR DE BAJA UN USUARIO
		//solicita confirmación
		public function baja(){		
			//recuperar usuario
			$u = Login::getUsuario();
			
			//asegurarse que el usuario está identificado
			if(!$u) throw new Exception('Debes estar identificado para poder darte de baja');
			
			//si no nos están enviando la conformación de baja
			if(empty($_POST['confirmar'])){	
				//carga el formulario de confirmación
				$datos = array();
				$datos['usuario'] = $u;
				$this->load_view('view/usuarios/baja.php', $datos);
		
			//si nos están enviando la confirmación de baja
			}else{
				//validar password
				$p = MD5(Database::get()->real_escape_string($_POST['password']));
				if($u->password != $p) 
					throw new Exception('El password no coincide, no se puede procesar la baja');
				
				//de borrar el usuario actual en la BDD
				if(!$u->borrar())
					throw new Exception('No se pudo dar de baja');
						
				//borra la imagen (solamente en caso que no sea imagen por defecto)
				if($u->imagen!=Config::get()->default_user_image)
					@unlink($u->imagen); 
			
				//cierra la sesion
				Login::log_out();
					
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = null;
				$datos['mensaje'] = 'Eliminado OK';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
	}
?>