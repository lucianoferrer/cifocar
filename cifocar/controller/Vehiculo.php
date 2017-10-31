<?php
	//CONTROLADOR Vehiculo 
	// implementa las operaciones que puede realizar el usuario
	class Vehiculo extends Controller{

	    //PROCEDIMIENTO PARA REGISTRAR UN NUEVO VEHICULO
	    public function registrar(){
	        $usuario=Login::getUsuario();
            //coomprobar si esta identificado
            if(!$usuario)
                throw new Exception('Debes estar identificado');
	        //comprobar si tienes privilegios
	        if($usuario->privilegio!=1)
	            throw new Exception('Debes Responsable de compras para añadir un vehículo');
            //si no llegan los datos a guardar
            if(empty($_POST['guardar'])){
                //mostramos la vista del formulario
                $datos = array();
                $this->load('model/MarcaModel.php');
                $datos['marcas']=MarcaModel::getMarcas(1000);
                $datos['max_image_size'] = Config::get()->user_image_max_size;
                $datos['usuario'] = $usuario;
                $this->load_view('view/vehiculos/nuevo.php', $datos);
            //si llegan los datos por POST
            }else{
            //crear una instancia del Vehiculo
                $this->load('model/VehiculoModel.php');
                $vehiculo = new VehiculoModel();
                $conexion = Database::get();
            //tomar los datos que vienen por POST
            //real_escape_string evita las SQL Injections
                $vehiculo->matricula=$conexion->real_escape_string($_POST['matricula']);
                $vehiculo->modelo=$conexion->real_escape_string($_POST['modelo']);
                $vehiculo->color=$conexion->real_escape_string($_POST['color']);
                $vehiculo->precio_venta=$conexion->real_escape_string($_POST['precio_venta']);
                $vehiculo->precio_compra=$conexion->real_escape_string($_POST['precio_compra']);
                $vehiculo->kms=$conexion->real_escape_string(intval($_POST['kms']));
                $vehiculo->caballos=$conexion->real_escape_string(intval($_POST['caballos']));
                $vehiculo->estado=$conexion->real_escape_string(intval($_POST['estado']));
                $vehiculo->any_matriculacion=$conexion->real_escape_string(intval($_POST['any_matriculacion']));
                $vehiculo->detalles=$conexion->real_escape_string($_POST['detalles']);
                $vehiculo->marca=$conexion->real_escape_string($_POST['marca']);
            // Tratamiento de la imagen
            //recuperar el fichero
                $fichero = $_FILES['imagen'];
                $destino = 'images/vehiculos/';
                $tam_maximo = Config::get()->user_image_max_size;
                $renombrar = true;
                $upload = new Upload($fichero, $destino, $tam_maximo, $renombrar);
                $vehiculo->imagen = $upload->upload_image();
            //guardar el vehiculo en BDD
                if(!$vehiculo->guardar()){
                    unlink($vehiculo->imagen);
                    throw new Exception('No se pudo guardar el vehiculo');
	                }
            //mostrar la vista de éxito
                $datos = array();
                $datos['usuario'] = Login::getUsuario();
                $datos['max_image_size']=Config::get()->user_image_max_size;
                $datos['mensaje'] = 'Operación de guardado completada con éxito';
                $this->load_view('view/exito.php', $datos);
            }
	    }
	    //PROCEDIMIENTO PARA LISTAR LOS VEHICULOS Modo Admin
	    public function listarAdmin($pagina){
	        $usuario=Login::getUsuario();
	        //coomprobar si esta identificado
	        if(!$usuario)
	            throw new Exception('Debes estar identificado');
            //coomprobar si as admin
            if(!Login::isAdmin())
                throw new Exception('Debes ser admin');
            $this->load('model/VehiculoModel.php');
            //si me piden APLICAR un filtro
            if(!empty($_POST['filtrar'])){
            //recupera el filtro a aplicar
                $f = new stdClass(); //filtro
                $f->texto = htmlspecialchars($_POST['texto']);
                $f->campo = htmlspecialchars($_POST['campo']);
                $f->campoOrden = htmlspecialchars($_POST['campoOrden']);
                $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
            //guarda el filtro en un var de sesión
                $_SESSION['filtroVehiculos'] = serialize($f);
            }
            //si me piden QUITAR un filtro
            if(!empty($_POST['quitarFiltro']))
                unset($_SESSION['filtroVehiculos']);
            //comprobar si hay filtro
            $filtro = empty($_SESSION['filtroVehiculos'])? false : unserialize($_SESSION['filtroVehiculos']);
            //para la paginación
            $num = 10; //numero de resultados por página
            $pagina = abs(intval($pagina)); //para evitar cosas raras por url
            $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
            $offset = $num*($pagina-1); //offset
            //si no hay que filtrar los resultados...
            if(!$filtro){
            //recupera todos los vehiculos
                $vehiculos = VehiculoModel::getVehiculos($num, $offset);
            //total de registros (para paginación)
                $totalRegistros = VehiculoModel::getTotal();
            }else{
            //recupera los vehiculos con el filtro aplicado
                $vehiculos = VehiculoModel::getVehiculos($num, $offset, $filtro->texto, $filtro->campo, $filtro->campoOrden, $filtro->sentidoOrden);
            //total de registros (para paginación)
                $totalRegistros = VehiculoModel::getTotal($filtro->texto, $filtro->campo);
            }
            //cargar la vista del listado
            $datos = array();
            $datos['usuario'] = Login::getUsuario();
            $datos['vehiculos'] = $vehiculos;
            $datos['filtro'] = $filtro;
            $datos['paginaActual'] = $pagina;
            $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
            $datos['totalRegistros'] = $totalRegistros;
            $datos['regPorPagina'] = $num;
	                
            $this->load_view('view/vehiculos/listaAdmin.php', $datos); // vista del admin
	    }
	    
	    //PROCEDIMIENTO PARA LISTAR LOS VEHICULOS Vendedores y Rpble compras
	    public function listar($pagina){
	        $usuario=Login::getUsuario();
	        //coomprobar si esta identificado
	        if(!$usuario)
	            throw new Exception('Debes estar identificado');
	            
	        $this->load('model/VehiculoModel.php');
	        //si me piden APLICAR un filtro
	        if(!empty($_POST['filtrar'])){
            //recupera el filtro a aplicar
	            $f = new stdClass(); //filtro
	            $f->texto = htmlspecialchars($_POST['texto']);
	            $f->campo = htmlspecialchars($_POST['campo']);
	            $f->campoOrden = htmlspecialchars($_POST['campoOrden']);
	            $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
	            //guarda el filtro en un var de sesión
                $_SESSION['filtroVehiculos'] = serialize($f);
	        }
	        //si me piden QUITAR un filtro
	        if(!empty($_POST['quitarFiltro']))
	            unset($_SESSION['filtroVehiculos']);
            //comprobar si hay filtro
            $filtro = empty($_SESSION['filtroVehiculos'])? false : unserialize($_SESSION['filtroVehiculos']);
            //para la paginación
            $num = 10; //numero de resultados por página
            $pagina = abs(intval($pagina)); //para evitar cosas raras por url
            $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
            $offset = $num*($pagina-1); //offset
            //si no hay que filtrar los resultados...
            if(!$filtro){
            //recupera todos los vehiculos
                $vehiculos = VehiculoModel::getVehiculos($num, $offset);
            //total de registros (para paginación)
                $totalRegistros = VehiculoModel::getTotal();
            }else{
            //recupera los vehiculos con el filtro aplicado
                $vehiculos = VehiculoModel::getVehiculos($num, $offset, $filtro->texto, $filtro->campo, $filtro->campoOrden, $filtro->sentidoOrden);
            //total de registros (para paginación)
                $totalRegistros = VehiculoModel::getTotal($filtro->texto, $filtro->campo);
            }
            //cargar la vista del listado
            $datos = array();
            $datos['usuario'] = Login::getUsuario();
            $datos['vehiculos'] = $vehiculos;
            $datos['filtro'] = $filtro;
            $datos['paginaActual'] = $pagina;
            $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
            $datos['totalRegistros'] = $totalRegistros;
            $datos['regPorPagina'] = $num;
	            
//             if($usuario->privilegio==1)
//                 $this->load_view('view/vehiculos/listaCompras.php', $datos); // vista del rpble de compras
//             else
//                 $this->load_view('view/vehiculos/listaVendedores.php', $datos); // vista de los vendedores
            $this->load_view('view/vehiculos/lista.php', $datos);
	    }
	    
	    //PROCEDIMIENTO PARA VER LOS DETALLES DE UN VEHICULO
	    public function ver($id=0){
	        //comprobar que llega la ID
	        if(!$id)
	            throw new Exception('No se ha indicado la ID del vehiculo');
            //recuperar el vehiculo con el ID seleccionado
            $this->load('model/VehiculoModel.php');
            $vehiculo = VehiculoModel::getVehiculo($id);
            if(!empty($vehiculo->vendedor))
                $vendedorNombre=UsuarioModel::getUsuarioId($vehiculo->vendedor)->nombre;
            else 
                $vendedorNombre='';
            //comprobar que el vehiculo existe
            if(!$vehiculo)
                throw new Exception('No existe el vehiclo con código '.$id);
            //cargar la vista de detalles
            $datos = array();
            $datos['usuario'] = Login::getUsuario();
            $datos['vendedorNombre']=$vendedorNombre;            
            $datos['vehiculo'] = $vehiculo;
                $this->load_view('view/vehiculos/detalles.php', $datos);
	    }
	    
	    //PROCEDIMIENTO PARA EDITAR UN VEHICULO RESPONSABLE DE COMPRAS
	    public function editarCompras($id=0){
        //comprobar que el usuario es responsable de compras
	        $usuario=Login::getUsuario();
	        if($usuario->privilegio!=1)
	            throw new Exception('Debes ser reponsable de compras');
            //comprobar que me llega un id
            if(!$id)
                throw new Exception('No se indicó el id del vehiculo');
            //recuperar el vehiculo con ese id
            $this->load('model/VehiculoModel.php');
            $vehiculo = VehiculoModel::getVehiculo($id);
            //comprobar que existe el vehiculo
            if(!$vehiculo)
                throw new Exception('No existe el vehiculo');
            //si no me están enviando el formulario
            if(empty($_POST['modificar'])){
            //poner el formulario
                $datos = array();
                $datos['usuario'] = Login::getUsuario();
                $datos['vendedores']=UsuarioModel::getUsuarios(1000,0,2,'privilegio');
                $this->load('model/MarcaModel.php');
                $datos['marcas']=MarcaModel::getMarcas();
                $datos['max_image_size']=Config::get()->user_image_max_size;
                $datos['vehiculo'] = $vehiculo;
                $this->load_view('view/vehiculos/modificarCompras.php', $datos);
            }else{
            //en caso contrario
                $conexion = Database::get();
            //actualizar los campos del vehiculo con los datos POST
                $vehiculo->matricula=$conexion->real_escape_string($_POST['matricula']);
                $vehiculo->modelo=$conexion->real_escape_string($_POST['modelo']);
                $vehiculo->color=$conexion->real_escape_string($_POST['color']);
                $vehiculo->precio_venta=$conexion->real_escape_string($_POST['precio_venta']);
                $vehiculo->precio_compra=$conexion->real_escape_string($_POST['precio_compra']);
                $vehiculo->kms=$conexion->real_escape_string(intval($_POST['kms']));
                $vehiculo->caballos=$conexion->real_escape_string(intval($_POST['caballos']));
                if(!empty($_POST['fecha_venta']))
                    $vehiculo->fecha_venta=$conexion->real_escape_string($_POST['fecha_venta']);
                else
                    $vehiculo->fecha_venta='';
                $vehiculo->estado=$conexion->real_escape_string(intval($_POST['estado']));
                $vehiculo->any_matriculacion=$conexion->real_escape_string(intval($_POST['any_matriculacion']));
                $vehiculo->detalles=$conexion->real_escape_string($_POST['detalles']);
                if(!empty($_POST['vendedor']))
                    $vehiculo->vendedor=$conexion->real_escape_string($_POST['vendedor']);
                else 
                    $vehiculo->vendedor='';
                $vehiculo->marca=$conexion->real_escape_string($_POST['marca']);
            // Tratamiento de la imagen
            //recuperar el fichero
                $fichero = $_FILES['imagen'];
            //si me indican una nueva imagen
                if($fichero['error']!=UPLOAD_ERR_NO_FILE){
                    $fotoAntigua = $vehiculo->imagen;
                    $destino = 'images/vehiculos/';
                    $tam_maximo = Config::get()->user_image_max_size;
                    $renombrar = true;
                    $upload = new Upload($fichero, $destino, $tam_maximo, $renombrar);
                    $vehiculo->imagen = $upload->upload_image();
                //borrar la antigua
                    unlink($fotoAntigua);
                }
            //modificar el vehiculo en la BDD
                if(!$vehiculo->actualizar())
                    throw new Exception('No se pudo actualizar');
            //cargar la vista de éxito
                $datos = array();
                $datos['usuario'] = Login::getUsuario();
                $datos['mensaje'] = "Datos del vehiculo <a href='index.php?controlador=Vehicuki&operacion=ver&parametro=$vehiculo->id'>'$vehiculo->modelo '</a> actualizados correctamente.";
                $this->load_view('view/exito.php', $datos);
            }
	    }
	    
	    //PROCEDIMIENTO PARA EDITAR ESTADO de un vehiculo 
	    public function editarEstado($id=0){
        //comprobar que el usuario es vendedor
	        $usuario=Login::getUsuario();
	        if($usuario->privilegio!=2)
	            throw new Exception('Debes ser vendedor');
        //comprobar que me llega un id
            if(!$id)
                throw new Exception('No se indicó el id de vehiculo');
        //recuperar el vehiculo con ese id
            $this->load('model/VehiculoModel.php');
            $vehiculo = VehiculoModel::getVehiculo($id);
        //comprobar que existe el vehiculo
            if(!$vehiculo)
                throw new Exception('No existe el vehiculo');
        //si no me están enviando el formulario
            if(empty($_POST['modificarEstado'])){
            //poner el formulario
                $datos = array();
                $datos['usuario'] = Login::getUsuario();
                $datos['vehiculo'] = $vehiculo;
                $this->load_view('view/vehiculos/modificarEstado.php', $datos);
            }else{
            //en caso contrario
                $conexion = Database::get();
            //actualizar el estado del vehiculo con datos POST
                $vehiculo->estado = $conexion->real_escape_string(intval($_POST['estado']));
            //modificar el vehiculo en la BDD
                if(!$vehiculo->actualizarEstado())
                    throw new Exception('No se pudo actualizar');
            //cargar la vista de éxito
                $datos = array();
                $datos['usuario'] = Login::getUsuario();
                $datos['mensaje'] = "Estado del vehiculo <a href='index.php?controlador=Vehiculo&operacion=ver&parametro=$vehiculo->id'>'$vehiculo->marca'</a> actualizado correctamente.";
                $this->load_view('view/exito.php', $datos);
            }
	    }
	    
	    //PROCEDIMIENTO PARA BORRAR UN VEHICULO
	    public function borrar($id=0){
        //comprobar que el usuario sea admin
	        if(!Login::isAdmin())
	            throw new Exception('Debes ser ADMIN');
        //comprobar que se ha indicado un id
            if(!$id)
                throw new Exception('No se indicó el vehiculo a borrar');
        //recuperar el vehiculo con ese id
            $this->load('model/VehiculoModel.php');
            $vehiculo = VehiculoModel::getVehiculo($id);
        //comprobar que existe dicho vehiculo
            if(!$vehiculo)
                throw new Exception('No existe el vehiculo con id '.$id);
        //si no me envian el formulario de confirmación
            if(empty($_POST['confirmarborrado'])){
            //mostrar el formularion de confirmación junto con los datos del vehiculo
                $datos = array();
                $datos['usuario'] = Login::getUsuario();
                $datos['vehiculo'] = $vehiculo;
                $this->load_view('view/vehiculos/confirmarborrado.php', $datos);
            //si me envian el formulario...
            }else{
            //borramos e vehiculo de la BDD
                if(!VehiculoModel::borrar($id))
                    throw new Exception('No se pudo borrar, es posible que se haya borrado ya.');
            //borra la imagen del vehiculo del servidor
                @unlink($vehiculo->imagen);
            //cargar la vista de éxito
                $datos = array();
                $datos['usuario'] = Login::getUsuario();
                $datos['mensaje'] = 'Operación de borrado ejecutada con éxito.';
                $this->load_view('view/exito.php', $datos);
            }
	    }
	}
?>