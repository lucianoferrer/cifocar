<?php		
	/* xml_library.php
	 *
	 * Librería para la manipulación de XML en el Robs Micro Framework (RMF).
	 *
	 * Dependencias: --
	 *
	 * Autor: Robert Sallent
	 * Última revisión: 05/11/2016
	 * */

	class XML{	
		//método que valida con DTD
	    public static function validateWithDTD($fichero){
	    	$dom = new DOMDocument();
	    	$dom->load($fichero, LIBXML_DTDLOAD);
	    	return $dom->validate();
	    }
	
	    //método que valida con XMLSchema
	    public static function validateWithSchema($fichero, $esquema){
	    	$dom = new DOMDocument();
	    	$dom->load($fichero);
	    	return $dom->schemaValidate($esquema);
	    }
	    
	    //método que convierte un array de objetos en un XML
	    //RECIBE:
	    // - $lista: lista de objetos
	    // - $root: nombre para la etiqueta del elemento raíz (opcional)
	    // - $name: nombre para la etiqueta de cada elemento de la lista (opcional),
	    // 	 si no se indica usa el nombre de la clase del elemento.
	    // - $ns: namespace (opcional)
	    
	    //DEVUELVE: un String con el XML resultante.
	    
	    public static function toXML($lista, $root='root', $name='', $ns='http://ejemplo.org/xml'){
	    	$xml = new DOMDocument("1.0", "utf-8");
	    	$xml->preserveWhiteSpace = false;
	    	$xml->formatOutput = true;
	    		
	    	$raiz = $xml->createElement($root);
	    	$raiz->setAttribute('xmlns', $ns);
	    		
	    	foreach($lista as $objeto){
	    		$nombre = empty($name)? get_class($objeto) : $name;
	    		$elemento = $xml->createElement($nombre);
	    
	    		foreach($objeto as $campo=>$valor)
	    			$elemento->appendChild($xml->createElement($campo, $valor));
	    		
	    		$raiz->appendChild($elemento);
	    	}
	    	$xml->appendChild($raiz);
	    	return $xml->saveXML();
	    }
	}
?>