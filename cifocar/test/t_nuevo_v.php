<?php
require '../config/Config.php';
require '../libraries/database_library.php';
require '../Model/VehiculoModel.php';

$vehiculo=new VehiculoModel();
$vehiculo->matricula="0012-JPG";
$vehiculo->modelo="CX-5";
$vehiculo->color="blanco";
$vehiculo->precio_venta=25000;
$vehiculo->precio_compra=23000;
$vehiculo->kms=25000;
$vehiculo->caballos=160;
$vehiculo->fecha_venta='2015-09-15';
$vehiculo->estado=2;
$vehiculo->any_matriculacion=2014;
$vehiculo->detalles="bla bla bla";
// $vehiculo->imagen="cx3.jpg";
$vehiculo->vendedor=4;
$vehiculo->marca="Mazda";

if($vehiculo->guardar())
    echo "guardado correcto";
else 
    echo "guardado malo";
   
?>