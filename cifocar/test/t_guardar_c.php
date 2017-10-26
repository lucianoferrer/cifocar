<?php
require '../config/Config.php';
require '../libraries/database_library.php';
require '../Model/CapituloModel.php';

//Prueba de guardado
$capitulo= new CapituloModel();
$capitulo->capitulo=125;
$capitulo->temporada=10;
$capitulo->titulo="Bart presidente";
$capitulo->descripcion="Bart se convierte en presidente de EEUU";
$capitulo->duracion=22;
$capitulo->fecha_emision='1989-01-01';

if(!$capitulo->guardar())
    echo 'No se pudo guardar';
else 
    echo 'Guardado OK';
?>