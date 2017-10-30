<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Listado de vehiculos</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			Template::header(); //pone el header

			if(!$usuario) Template::login(); //pone el formulario de login
			else Template::logout($usuario); //pone el formulario de logout
			
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			<h2>Listado de vehiculos</h2>
			
			<p class="infolista">Hay <?php echo $totalRegistros; ?> registros<?php echo $filtro? ' para el filtro indicado':'';?>, 
			mostrando del <?php echo ($paginaActual-1)*$regPorPagina+1;?> al <?php echo ($paginaActual-1)*$regPorPagina+sizeof($vehiculos);?>.</p>
			
			
			<?php if(!$filtro){?>
			<form method="post" class="filtro" action="index.php?controlador=Vehiculo&operacion=listar&parametro=1">
				<label>Filtro:</label>
				<input type="text" name="texto" placeholder="buscar..."/>
				<select name="campo">
					<option value="matricula">Matrículo</option>
					<option value="marca">Marca</option>
					<option value="modelo">Modelo</option>
				</select>
				<label>Orden:</label>
				<select name="campoOrden">
					<option value="matricula">Matrícula</option>
					<option value="marca">Marca</option>
					<option value="modelo">Modelo</option>
				</select>
				<select name="sentidoOrden">
					<option value="ASC">ascendente</option>
					<option value="DESC">descendente</option>
				</select>
				<input type="submit" name="filtrar" value="Filtrar"/>
			</form>
			<?php }else{ ?>
			    <form method="post" class="filtro" action="index.php?controlador=Vehiculo&operacion=listar&parametro=1">
			    	<label>Quitar filtro (<?php echo $filtro->campo.": '".$filtro->texto."', ordenado: ".$filtro->campoOrden." ".$filtro->sentidoOrden;?>)</label>
			    	<input type="submit" name="quitarFiltro" value="Quitar" />
			    </form>
			<?php }?>
			
			<table>
				<tr>
					<th>Imagen</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Matrícula</th>
					<th>Color</th>
					<th>Precio Venta</th>
					<th>estado</th>
					<th>Año matriculación</th>
					<th colspan="3">Operaciones</th>
				</tr>
				<?php 
				foreach($vehiculos as $vehiculo){
				    if ($vehiculo->estado==0) $estado="En venta";
				    elseif ($vehiculo->estado==1) $estado="Reservado";
				    elseif ($vehiculo->estado==2) $estado="Vendido";
				    elseif ($vehiculo->estado==3) $estado="Devolución";
				    elseif ($vehiculo->estado==4) $estado="Baja";
				    echo "<tr>";
				    echo "<td class='foto'><img class='miniatura' src='$vehiculo->imagen' alt='Imagen de $vehiculo->modelo' title='Imagen del $vehiculo->modelo'/></td>";
				    echo "<td>$vehiculo->marca</td>";
				    echo "<td>$vehiculo->modelo</td>";
				    echo "<td>$vehiculo->matricula</td>";
				    echo "<td>$vehiculo->color</td>";
				    echo "<td>$vehiculo->precio_venta</td>";
				    echo "<td>$estado</td>";
				    echo "<td>$vehiculo->any_matriculacion</td>";
				    echo "<td class='foto'><a href='index.php?controlador=Vehiculo&operacion=ver&parametro=$vehiculo->id'><img class='boton' src='images/buttons/view.png' alt='ver detalles' title='ver detalles'/></a></td>";
				    echo "<td class='foto'><a href='index.php?controlador=Vehiculo&operacion=editarEstado&parametro=$vehiculo->id'><img class='boton' src='images/buttons/edit.png' alt='ver detalles' title='ver detalles'/></a></td>";
				    echo "</tr>";
				}
				?>
			</table>
			<ul class="paginacion">
				<?php
    				//poner enlace a la página anterior
    				if($paginaActual>1){
    				    echo "<li><a href='index.php?controlador=Receta&operacion=listar&parametro=1'>Primera</a></li>";
    				}
				
				    //poner enlace a la página anterior
    				if($paginaActual>2){
    				    echo "<li><a href='index.php?controlador=Receta&operacion=listar&parametro=".($paginaActual-1)."'>Anterior</a></li>";
    				}
				    //poner enlace a la página siguiente
    				if($paginaActual<$paginas-1){
    				    echo "<li><a href='index.php?controlador=Receta&operacion=listar&parametro=".($paginaActual+1)."'>Siguiente</a></li>";
    				}
    				
				    //Poner enlace a la última página
				    if($paginas>1 && $paginaActual<$paginas){
				        echo "<li><a href='index.php?controlador=Receta&operacion=listar&parametro=$paginas'>Ultima</a></li>";
				    }
				?>
			</ul>
			<p class="infolista">Viendo la página <?php echo $paginaActual.' de '.$paginas; ?> páginas de resultados</p>
			
			
			<p class="volver" onclick="history.back();">Atrás</p>
		
		</section>
		
		<?php Template::footer();?>
    </body>
</html>