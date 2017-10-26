<?php
require '../config/Config.php';
require '../libraries/database_library.php';
require '../Model/UsuarioModel.php';

$usuario=new UsuarioModel();
$usuario->user="user7";
$usuario->password="1234";
$usuario->nombre="user7";
$usuario->privilegio=2;
$usuario->email="user7@user.com";
$usuario->admin=0;
$usuario->imagen="imagenuser7";

if($usuario->guardar())
    echo "guardado correcto";
else 
    echo "guardado malo";
   
?>