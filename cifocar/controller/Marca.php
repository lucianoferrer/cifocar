<?php
	//CONTROLADOR MARA 
	class Marca extends Controller{

		//PROCEDIMIENTO PARA GUARDAR UNA NUEVA MARCA
		public function nueva(){
		    //comprobar si eres responsable de compras
		    $usuario=Login::getUsuario();
		    if(!$usuario)
		        throw new Exception('Debes estar identificado');
	        if($usuario->privilegio!=1)
		        throw new Exception('Debes ser Responsable de compras');

			//si no llegan los datos a guardar
			if(empty($_POST['guardar'])){
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$this->load_view('view/marcas/nueva.php', $datos);
			
			//si llegan los datos por POST
			}else{
				//crear una instancia de Marca
				$this->load('model/MarcaModel.php');
				$marca = new MarcaModel();
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$marca->marca = $conexion->real_escape_string($_POST['marca']);
				if(MarcaModel::getMarca($marca->marca))
				    throw new Exception('Esta marca ya existe');
				//guardar la marca en BDD
				if(!$marca->guardar()){
					throw new Exception('No se pudo guardar la marca');
				}
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Operación de guardado completada con éxito';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		
		//PROCEDIMIENTO PARA LISTAR LAS MARCAS
		public function listar($pagina){
		    $this->load('model/MarcaModel.php');
		    
		    //si me piden APLICAR un filtro
		    if(!empty($_POST['filtrar'])){
		        //recupera el filtro a aplicar
		        $f = new stdClass(); //filtro
		        $f->texto = htmlspecialchars($_POST['texto']);
		        $f->campo = htmlspecialchars($_POST['campo']);
		        $f->campoOrden = htmlspecialchars($_POST['campoOrden']);
		        $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
		        
		        //guarda el filtro en un var de sesión
		        $_SESSION['filtroMarcas'] = serialize($f);
		    }
		  
		    //si me piden QUITAR un filtro
		    if(!empty($_POST['quitarFiltro']))
		        unset($_SESSION['filtroMarcass']);
		    
		    
	        //comprobar si hay filtro
	        $filtro = empty($_SESSION['filtroMarcas'])? false : unserialize($_SESSION['filtroMarcas']);
		        
		    //para la paginación
		    $num = 5; //numero de resultados por página
		    $pagina = abs(intval($pagina)); //para evitar cosas raras por url
		    $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
		    $offset = $num*($pagina-1); //offset
		    
		    //si no hay que filtrar los resultados...
		    if(!$filtro){
		      //recupera todas las marcas
		      $marcas = MarcaModel::getMarcas(1000);
		      //total de registros (para paginación)
		      $totalRegistros = MarcaModel::getTotal();
		    }else{
		      //recupera las marcas con el filtro aplicado
		      $marcas = MarcaModel::getMarcas($num, $offset, $filtro->texto, $filtro->campo, $filtro->campoOrden, $filtro->sentidoOrden);
		      //total de registros (para paginación)
		      $totalRegistros = MarcaModel::getTotal($filtro->texto, $filtro->campo);
		    }
		    
		    //cargar la vista del listado
		    $datos = array();
		    $datos['usuario'] = Login::getUsuario();
		    $datos['marcas'] = $marcas;
		    $datos['filtro'] = $filtro;
		    $datos['paginaActual'] = $pagina;
		    $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
		    $datos['totalRegistros'] = $totalRegistros;
		    $datos['regPorPagina'] = $num;
		    
            $this->load_view('view/marcas/lista.php', $datos);
		}
		
		//PROCEDIMIENTO PARA EDITAR UNA RECETA
		public function editar($marca){
		    //comprobar si eres responsable de compras
		    $usuario=Login::getUsuario();
		    if(!$usuario)
		        throw new Exception('Debes estar identificado');
	        if($usuario->privilegio!=1)
		            throw new Exception('Debes ser Responsable de compras');
		            
		    //comprobar que me llega un id
		    if(!$marca)
		        throw new Exception('No se indicó la marca');
		        
		    //recuperar la marca con esa id
		    $this->load('model/MarcaModel.php');
		    $marca = MarcaModel::getMarca($marca);
		    
		    //comprobar que existe la marca
		    if(!$marca)
		        throw new Exception('No existe la marca');   
		    
		    //si no me están enviando el formulario
		    if(empty($_POST['modificar'])){
		      //poner el formulario
		        $datos = array();
		        $datos['usuario'] = Login::getUsuario();
		        $datos['marca'] = $marca;
		        $this->load_view('view/marcas/modificar.php', $datos);

		    }else{
		    //en caso contrario
		        $conexion = Database::get();
		        $marcaold=$marca->marca;
		        $marcanew=$conexion->real_escape_string($_POST['marca']);

	            if(MarcaModel::actualizar($marcanew,$marcaold)>0)
	                $mensaje="Marca $marcanew modificada";
                else
                    $mensaje='No se pudo modificacar';
		      
		      //cargar la vista de éxito 
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = $mensaje;
	          $this->load_view('view/exito.php', $datos);
		    }
		}
		
		//PROCEDIMIENTO PARA BORRAR UNA MARCA
		public function borrar($marca=''){
		    //comprobar si eres responsable de compras
		    $usuario=Login::getUsuario();
		    if(!$usuario)
		        throw new Exception('Debes estar identificado');
	        if($usuario->privilegio!=1)
	            throw new Exception('Debes ser Responsable de compras');
		            
	       //comprobar que se ha indicado un id
	       if(!$marca)
	           throw new Exception('No se indicó la marca a borrar');
		       
	       //recuperar la marca con esa id aunque aquí no tiene mucho sentido, lo dejo.
	       $this->load('model/MarcaModel.php');
	       $marca = MarcaModel::getMarca($marca);
	       
	       //comprobar que existe dicha marca
	       if(!$marca)
	           throw new Exception('No existe la marca '.$marca);
	           
		   //si no me envian el formulario de confirmación
		   if(empty($_POST['confirmarborrado'])){
		      //mostrar el formularion de confirmación junto con los datos de la marca
		      $datos = array();
		      $datos['usuario'] = Login::getUsuario();
		      $datos['marca'] = $marca; 
		      $this->load_view('view/marcas/confirmarborrado.php', $datos);
		   
		   //si me envian el formulario...
		   }else{
		      //borramos la marca de la BDD
		      if(!MarcaModel::borrar($marca))
		          throw new Exception('No se pudo borrar, es posible que se haya borrado ya.');
      
		      //cargar la vista de éxito
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = 'Operación de borrado ejecutada con éxito.';
	          $this->load_view('view/exito.php', $datos);
		   }
		}
	}
?>