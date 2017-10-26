<?php
require '../config/Config.php';
require '../libraries/database_library.php';
require '../Model/MarcaModel.php';
require '../Model/VehiculoModel.php';
require '../Model/UsuarioModel.php';

$capitulo=MarcaModel::getMarca('Citroennnn');

var_dump($capitulo);

if(!$capitulo)
    throw new Exception('no se encuentra');

$marcaold=$capitulo->marca;
$capitulo->marca='Opel';

if($capitulo->actualizar('Citroennnn'))
    echo 'Modificado';
else
    echo 'No se pudo modificacr';
?>