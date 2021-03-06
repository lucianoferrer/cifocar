<?php
	class MarcaModel{
		//PROPIEDADES
		public $marca;
			
		//METODOS
		//guarda la marca en la BDD
		public function guardar(){
			$consulta = "INSERT INTO marcas(marca)
			VALUES ('$this->marca');";

			return Database::get()->query($consulta);
		}
		
		//método que me recupera el total de registros (incluso con filtros)
		public static function getTotal($t='', $c='marca'){
		    $consulta = "SELECT * FROM marcas
                         WHERE $c LIKE '%$t%'";
		    
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    $total = $resultados->num_rows;
		    $resultados->free();
		    return $total;
		}
		
		//actualiza los datos de la marca en la BDD
		public static function actualizar($new, $old){
			$consulta = "UPDATE marcas
							  SET marca='$new' 
							  WHERE marca='$old';";
			Database::get()->query($consulta);
			return Database::get()->affected_rows;
		}
		
		
		//Método que borra una marca de la BDD (de objeto)
		//PROTOTIPO: public boolean borrar()
		public static function borrar($marca){
		    $consulta = "DELETE FROM marcas
                         WHERE marca='$marca->marca';";
		    
		    $conexion = Database::get(); //conecta
		    $conexion->query($consulta); //ejecuta consulta
		    return $conexion->affected_rows; //devuelve el num de filas afectadas
		}
		//EJEMPLO DE USO (1):
		// $marca = MarcaModel::getMarca('mazda');
		
		//este método sirve para comprobar si existe la marca (en la BDD)
		public static function validar($m){
			$consulta = "SELECT * FROM marcas WHERE marca='$m';";
			$resultado = Database::get()->query($consulta);
			
			//si hay algun marca retornar true sino false
			$r = $resultado->num_rows;
			$resultado->free(); //libera el recurso resultset
			return $r;
		}
		
		//este método debería retornar la marca
		//de la BDD (o NULL si no existe), a partir de un nombre de marca
		public static function getMarca($m){
			$consulta = "SELECT * FROM marcas WHERE marca='$m';";
			$resultado = Database::get()->query($consulta);
			//si no había resultados, retornamos NULL
			if(!$resultado) return null;
			
			//convertir el resultado en un objeto RecetaModel
			$mar = $resultado->fetch_object('MarcaModel');
			//liberar memoria
			$resultado->free();
			
			//devolver el resultado
			return $mar;
		}	
		
		//método que me recupere todas las marcas
		//PROTOTIPO: public static array<MarcaModel> getMarcas()
		public static function getMarcas($l=10, $o=0, $t='', $c='marca', $co='marca', $so='ASC'){
	        //preparar la consulta
		    $consulta = "SELECT * FROM marcas
                         WHERE $c LIKE '%$t%'
                         ORDER BY $co $so
		                 LIMIT $l
		                 OFFSET $o;";
		    //conecto a la BDD y ejecuto la consulta
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    
		    //creo la lista de MarcaModel
		    $lista = array();
		    while($marca = $resultados->fetch_object('MarcaModel'))
		        $lista[] = $marca;
		        
	        //liberar memoria
	        $resultados->free();
		        
	        //retornar la lista de RecetaModel
	        return $lista;
		}
	}
?>