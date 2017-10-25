<?php
	class UsuarioModel{
		//PROPIEDADES
		public $id, $user, $password, $nombre, $privilegio=100, $admin=0, $email, $imagen='', $fecha;
			
		//METODOS
		//guarda el usuario en la BDD
		public function guardar(){
			$user_table = Config::get()->db_user_table;
			$consulta = "INSERT INTO $user_table(user, password, nombre, privilegio, admin, email, imagen)
			VALUES ('$this->user','$this->password','$this->nombre',100,0,'$this->email', '$this->imagen');";
				
			return Database::get()->query($consulta);
		}
		
		
		//actualiza los datos del usuario en la BDD
		public function actualizar(){
			$user_table = Config::get()->db_user_table;
			$consulta = "UPDATE $user_table
							  SET password='$this->password', 
							  		nombre='$this->nombre', 
							  		email='$this->email', 
							  		imagen='$this->imagen'
							  WHERE user='$this->user';";
			return Database::get()->query($consulta);
		}
		
		
		//elimina el usuario de la BDD
		public function borrar(){
			$user_table = Config::get()->db_user_table;
			$consulta = "DELETE FROM $user_table WHERE user='$this->user';";
			return Database::get()->query($consulta);
		}
		
		
		
		//este método sirve para comprobar user y password (en la BDD)
		public static function validar($u, $p){
			$user_table = Config::get()->db_user_table;
			$consulta = "SELECT * FROM $user_table WHERE user='$u' AND password='$p';";
			$resultado = Database::get()->query($consulta);
			
			//si hay algun usuario retornar true sino false
			$r = $resultado->num_rows;
			$resultado->free(); //libera el recurso resultset
			return $r;
		}
		
		//este método debería retornar un usuario creado con los datos 
		//de la BDD (o NULL si no existe), a partir de un nombre de usuario
		public static function getUsuario($u){
			$user_table = Config::get()->db_user_table;
			$consulta = "SELECT * FROM $user_table WHERE user='$u';";
			$resultado = Database::get()->query($consulta);
			
			$us = $resultado->fetch_object('UsuarioModel');
			$resultado->free();
			
			return $us;
		}	
	}
?>