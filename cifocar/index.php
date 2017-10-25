<?php 
	//flag para controlar que se accede mediante el index
	$index_access = true;
	
	//carga de recursos que necesita el framework para funcionar
	require_once 'config/Config.php';
	require_once 'model/UsuarioModel.php';
	
	require_once 'libraries/database_library.php';
	require_once 'libraries/login_library.php';
	require_once 'libraries/upload_library.php';
	
	require_once 'templates/Template.php';

	//carga del controlador principal
	require 'controller/Controller.php';
	require 'controller/FrontController.php';
	
	//crea una instancia del controlador frontal
	$fc = new FrontController();
	
	//ejecuta el método principal del controlador frontal
	$fc->main();
?>