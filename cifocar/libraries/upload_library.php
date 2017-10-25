<?php 
	/* upload_library.php
	 * 
	 * Librería para la subida de ficheros en el Robs Micro Framework (RMF).
	 * 
	 * Dependencias: --
	 * 
	 * Autor: Robert Sallent
	 * Última revisión: 05/11/2016
	 * */		

	class Upload{
		//-----------------------------------------------------------------------------------
		//PROPIEDADES
		//-----------------------------------------------------------------------------------
		private $file, $destino, $max_size, $renombrar, $nombrefinal;
		
		//-----------------------------------------------------------------------------------
		//CONSTRUCTOR
		//-----------------------------------------------------------------------------------
		public function __construct($fi, $de, $ma=0, $re=true){
			$this->file = $fi;
			$this->destino = $de; 
			$this->max_size = $ma;
			$this->renombrar = $re;
			
			$extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
			
			if($this->renombrar)
				$this->nombrefinal = $this->generar_nombre(20,true, $extension);
			else
				$this->nombrefinal = $this->file['name'];
		}
		
		//-----------------------------------------------------------------------------------
		//METODOS
		//-----------------------------------------------------------------------------------
		//método que sube una imagen (comprobando que sea imagen)
		public function upload_image(){
						
			//control de errores en la subida de fichero
			switch($this->file['error']){
				case 0: break; //OK
				case 1: 
				case 2: throw new Exception('El fichero es demasiado grande');
				case 3: throw new Exception('El fichero se subió de forma parcial');
				case 4: throw new Exception('No se indicó ningún fichero');
				default: throw new Exception('Error en la subida del fichero');
			}
			
			if($this->max_size && $this->file['size']>$this->max_size)
				throw new Exception('El fichero supera el tamaño máximo'); 
			
			$rutatemporal = $this->file['tmp_name']; //ruta en /tmp

			if(!is_uploaded_file($rutatemporal))
				throw new Exception('El fichero no fue subido por POST'); 
				
			if(!getimagesize($rutatemporal))
				throw new Exception('El fichero no es de imagen'); 
				
			$rutafinal = $this->destino.''.$this->nombrefinal;	
				
			if(!move_uploaded_file($rutatemporal, $rutafinal))
				throw new Exception('Error al mover el fichero de imagen');
			
			return $rutafinal;
		}
		
		
		//método para generar nombres aleatorios
		public static function generar_nombre($longitud=20, $unique='false', $extension = ''){
			$letras = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$nombre = '';
			
			//genera un nombre de  letras aleatorias
			for ($i = 0; $i<$longitud; $i++) 
				$nombre .= $letras[rand(0, strlen($letras)-1)];
			
			//incluye la extensión
			if($extension) $nombre=$nombre.'.'.$extension;
			
			//incluye un prefijo basado en el tiempo del procesador
			return $unique? uniqid().$nombre : $nombre;
		}
	}
?>