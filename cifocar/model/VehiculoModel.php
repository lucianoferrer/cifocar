<?php
	class VehiculoModel{
		//PROPIEDADES
	    public $id, $matricula, $modelo, $color,$precio_venta ,
	           $precio_compra ,$kms ,$caballos ,$fecha_venta ,
	           $estado ,$any_matriculacion ,$detalles ,$imagen;
			
		//METODOS
		//guarda el vehiculo en la BDD
		public function guardar(){
		    if (empty($this->imagen))
		        $img='DEFAULT';
	        else
                $img="'".$this->imagen."'"; 
		    
			$consulta = "INSERT INTO vehiculos(id, matricula, modelo, color,precio_venta ,
	           precio_compra ,kms ,caballos ,fecha_venta ,
	           estado ,any_matriculacion ,detalles ,imagen,vendedor,marca)
			VALUES (DEFAULT, '$this->matricula', '$this->modelo', '$this->color', $this->precio_venta,
	           $this->precio_compra ,$this->kms ,$this->caballos ,'$this->fecha_venta' ,
	           $this->estado,$this->any_matriculacion ,'$this->detalles' ,$img,$this->vendedor,'$this->marca');";
			echo $consulta;
			return Database::get()->query($consulta);
		}
		
		//método que me recupera el total de registros (incluso con filtros)
		public static function getTotal($t='', $c='marca'){
		    $consulta = "SELECT * FROM vehiculos
                         WHERE $c LIKE '%$t%'";
		    
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    $total = $resultados->num_rows;
		    $resultados->free();
		    return $total;
		}
		
		//actualiza los datos del vehiculo en la BDD
		public function actualizar(){
			$consulta = "UPDATE vehiculos
							  SET matricula='$this->matricula', 
							     modelo='$this->modelo',
                                 color='$this->color',
                                 precio_venta =$this->precio_venta,
	                             precio_compra=$this->precio_compra ,
	                             kms=$this->kms ,
	                             caballos=$this->caballos ,
	                             fecha_venta='$this->fecha_venta' ,
	                             estado=$this->estado ,
	                             any_matriculacion=$this->any_matriculacion ,
	                             detalles='$this->detalles' ,
	                             imagen='$this->imagen'; 
                            WHERE id='$this->id';";
			return Database::get()->query($consulta);
		}
		
		//Método que borra un vehiculo de la BDD (estático)
		//PROTOTIPO: public static boolean borrar(int $id)
		public static function borrar($id){
		    $consulta = "DELETE FROM vehiculos
                         WHERE id=$id;";
		    
		    $conexion = Database::get(); //conecta
		    $conexion->query($consulta); //ejecuta consulta
		    return $conexion->affected_rows; //devuelve el num de filas afectadas
		}
		//EJEMPLO DE USO
		//VehiculoModel::borrar(6)
		
		//Método que borra un vehiculo de la BDD (de objeto)
		//PROTOTIPO: public boolean borrar2()
		public function borrar2(){
		    $consulta = "DELETE FROM vehiculos
                         WHERE id=$this->id;";
		    
		    $conexion = Database::get(); //conecta
		    $conexion->query($consulta); //ejecuta consulta
		    return $conexion->affected_rows; //devuelve el num de filas afectadas
		}
		//EJEMPLO DE USO (1):
		// $vehiculo = VehiculoModel::getVehiculo(6);
		// $vehiculo->borrar2();
		
		//este método sirve para comprobar si existe el vehiculo (en la BDD)
		public static function validar($v){
			$consulta = "SELECT * FROM vehiculos WHERE vehiculo='$v';";
			$resultado = Database::get()->query($consulta);
			
			//si hay algun vehiculo retornar true sino false
			$r = $resultado->num_rows;
			$resultado->free(); //libera el recurso resultset
			return $r;
		}
		
		//este método debería retornar el vehiculo
		//de la BDD (o NULL si no existe), a partir de un id de vehiculo
		public static function getVehiculo($v){
			$consulta = "SELECT * FROM vehiculos WHERE id=$v;";
			$resultado = Database::get()->query($consulta);
			//si no había resultados, retornamos NULL
			if(!$resultado) return null;
			
			//convertir el resultado en un objeto VehiculoModel
			$veh = $resultado->fetch_object('VehiculoModel');
			//liberar memoria
			$resultado->free();
			
			//devolver el resultado
			return $veh;
		}	
		
		//método que me recupere todas los vehiculos
		//PROTOTIPO: public static array<VehiculoModel> getVehiculo()
		public static function getVehiculos($l=10, $o=0, $t='', $c='marca', $co='id', $so='ASC'){
		    //preparar la consulta
		    $consulta = "SELECT * FROM vehiculos
                         WHERE $c LIKE '%$t%'
                         ORDER BY $co $so
		                 LIMIT $l
		                 OFFSET $o;";
		    
		    //conecto a la BDD y ejecuto la consulta
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    
		    //creo la lista de VehiculoModel
		    $lista = array();
		    while($vehiculo = $resultados->fetch_object('VehiculoModel'))
		        $lista[] = $vehiculo;
		        
		        //liberar memoria
		        $resultados->free();
		        
		        //retornar la lista de VehiculoModel
		        return $lista;
		}
	}
?>