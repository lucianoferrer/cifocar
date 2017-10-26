<?php
require '../config/Config.php';
require '../libraries/database_library.php';
require '../Model/CapituloModel.php';

$capitulos=CapituloModel::getCapitulos();

$capitulo=CapituloModel::getCapitulo(2);

?>