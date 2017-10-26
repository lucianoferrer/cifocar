<?php
require '../config/Config.php';
require '../libraries/database_library.php';
require '../Model/MarcaModel.php';

$marca=new MarcaModel();
$marca->marca='Citroennnn';

if($marca->guardar())
    echo "guardado correcto";
else 
    echo "guardado malo";
   
?>