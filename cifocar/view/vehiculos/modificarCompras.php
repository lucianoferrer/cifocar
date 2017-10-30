<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificar Vehiculo <?php echo $vehiculo->modelo;?></title>
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
			
			<h2>Modificar vehiculo <?php echo $vehiculo->modelo;?></h2>
			
			<div class="contenedor">
    			<form class="texto" method="post" enctype="multipart/form-data" autocomplete="off">
					<label>ID:</label>
					<input type="text" name="id" disabled value="<?php echo $vehiculo->id;?>"/><br/>
					<label>Marca:</label>
					<select name="marca" required>
					<?php foreach($marcas as  $marca)
                        echo "<option value='$marca->marca'>$marca->marca</option>";?>
		        	</select>
					<br/><label>Modelo:</label>
					<input type="text" name="modelo" required="required" value="<?php echo $vehiculo->modelo;?>"/><br/>
					<label>Matrícula:</label>
					<input type="text" name="matricula" value="<?php echo $vehiculo->matricula;?>"pattern= "[0-9]{4}\W[A-Za-z]{3}$" title="4 números y tres letras separados por un guion o espacio" placeholder="0000-XXX" required="required"/><br/>
					<label>Color:</label>
					<input type="text" name="color" required="required" value="<?php echo $vehiculo->color;?>"/><br/>
					<label>Precio Venta:</label>
					<input type="number" name="precio_venta" required="required" value="<?php echo $vehiculo->precio_venta;?>"/><br/>
					<label>Precio Compra:</label>
					<input type="number" name="precio_compra" required="required" value="<?php echo $vehiculo->precio_compra;?>"/><br/>
					<label>KMS:</label>
					<input type="number" name="kms" required="required" value="<?php echo $vehiculo->kms;?>"/><br/>
					<label>Caballos:</label>
					<input type="number" name="caballos" required="required" value="<?php echo $vehiculo->caballos;?>"/><br/>
					<label>Fecha Venta:</label>
					<input type="number" name="fecha_venta" value="<?php echo $vehiculo->fecha_venta;?>"/><br/>
					<label>Estado:</label>
					<select name="estado" required>
						<?php $sel="selected='selected'";$nosel='';
						if($vehiculo->estado==0) {$e0=$sel;$e1=$nosel;$e2=$nosel;$e3=$nosel;$e4=$nosel;}
						elseif($vehiculo->estado==1) {$e0=$nosel;$e1=$sel;$e2=$nosel;$e3=$nosel;$e4=$nosel;}
						elseif($vehiculo->estado==2) {$e0=$nosel;$e1=$nosel;$e2=$sel;$e3=$nosel;$e4=$nosel;}
						elseif($vehiculo->estado==3) {$e0=$nosel;$e1=$nosel;$e2=$nosel;$e3=$sel;$e4=$nosel;}
						else{$e0=$nosel;$e1=$nosel;$e2=$nosel;$e3=$nosel;$e4=$sel;}?>
                	    <option value="0" $e0>En venta</option>
                    	<option value="1" $e1>Reservado</option>
	                    <option value="2" $e2>Vendido</option>
    	                <option value="3" $e3>Devolución</option>
        	            <option value="2" $e4>Baja</option>
					</select>
					<br/>
					<label>Vendedor:</label>
					<select name="vendedor" required>
					<?php foreach($vendedores as  $vendedor)
                        echo "<option value='$vendedor->id' if($vendedor->nombre==$vehiculo->vendedor) $sel else $nosel;>$vendedor->nombre</option>";?>
		        	</select>
					<br/>
					<label>Año Matriculación:</label>
					<input type="number" name="any_matriculacion" required="required"  value="<?php echo $vehiculo->any_matriculacion;?>"/><br/>
					<label>Detalles:</label>
					<textarea name="detalles"> <?php echo $vehiculo->caballos;?></textarea><br/>

					<label>Imagen:</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_image_size;?>" />		
					<input type="file" accept="image/*" name="imagen"/>
					<span>max <?php echo intval($max_image_size/1024);?>kb</span><br />

					<input type="submit" name="modificar" value="modificar"/><br/>    			
				</form>
    			
    			<div class="imagen">
	        		<figure class="imagen">
        			<?php 
        			echo "<img src='$vehiculo->imagen' alt='Imagen de $vehiculo->modelo' title='Imagen de $vehiculo->modelo'/>";
        			echo "<figcaption>$vehiculo->modelo</figcaption>";
        			?>
        		</figure>	
            		<h3>Eliminar vehiculo</h3>
            			<?php 
            			 echo "<a href='index.php?controlador=Vehiculo&operacion=borrar&parametro=$vehiculo->id'>";
            			 echo "<img class='boton' src='images/buttons/delete.png' alt='Borrar'>";
            			 echo "</a>";
            			?>
            	</div>	
        	</div>
        		
        	<p class="volver" onclick="history.back();">Atrás</p>	
			
		</section>
		
		<?php Template::footer();?>
    </body>
</html>