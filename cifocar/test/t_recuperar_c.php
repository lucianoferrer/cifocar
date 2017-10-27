<?php
require '../config/Config.php';
require '../libraries/database_library.php';
require '../Model/UsuarioModel.php';

// $capitulos=CapituloModel::getCapitulos();

// $capitulo=CapituloModel::getCapitulo(2);

$usuarios=UsuarioModel::getUsuarios();

echo var_dump($usuarios);

?>