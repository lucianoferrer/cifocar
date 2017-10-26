<?php
require '../config/Config.php';
require '../libraries/database_library.php';
require '../Model/MarcaModel.php';
require '../Model/VehiculoModel.php';
require '../Model/UsuarioModel.php';

$capitulo1=MarcaModel::getMarca('Citroennnn');
$capitulo1=VehiculoModel::getVehiculo(12);
$capitulo1=UsuarioModel::getUsuario(10);

var_dump($capitulo1);

// VehiculoModel::borrar(13);

//metodo 1
if($capitulo1 && $capitulo1->borrar()){
    echo "borrado correcto";}
else 
    echo "borrado malo";

    

?>