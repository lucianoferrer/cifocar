<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificar estado <?php echo $vehiculo->modelo;?></title>
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
			<h2>Modificar estado <?php echo $vehiculo->modelo;?></h2>
			<div class="contenedor">
    			<form class="texto" method="post" enctype="multipart/form-data" autocomplete="off">
					<h3>Estado</h3>
					<div class="flex-container">	
    					<select class="datos flex3" name="estado" required>
    						<?php $sel="selected='selected'";$nosel='';
    						if($vehiculo->estado==0) {$e0=$sel;$e1=$nosel;$e2=$nosel;$e3=$nosel;$e4=$nosel;}
    						elseif($vehiculo->estado==1) {$e0=$nosel;$e1=$sel;$e2=$nosel;$e3=$nosel;$e4=$nosel;}
    						elseif($vehiculo->estado==2) {echo "llego";$e0=$nosel;$e1=$nosel;$e2=$sel;$e3=$nosel;$e4=$nosel;}
    						elseif($vehiculo->estado==3) {$e0=$nosel;$e1=$nosel;$e2=$nosel;$e3=$sel;$e4=$nosel;}
    						else{$e0=$nosel;$e1=$nosel;$e2=$nosel;$e3=$nosel;$e4=$sel;}?>
                    	    <option value="0" $e0>En venta</option>
                        	<option value="1" $e1>Reservado</option>
    	                    <option value="2" $e2>Vendido</option>
        	                <option value="3" $e3>Devolución</option>
            	            <option value="2" $e4>Baja</option>
    					</select>
    				</div>	

					<div class="flex-container"><h3 class="flex1">Estado:</h3>		<h2 class="flex3"><?php echo $vehiculo->estado; ?></h2></div>
					<div class="flex-container"><h3 class="flex1">Marca:</h3>		<h2 class="flex3"><?php echo $vehiculo->marca; ?></h2></div>
					<div class="flex-container"><h3 class="flex1">Modelo:</h3>		<h2 class="flex3"><?php echo $vehiculo->modelo;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Matricula:</h3>	<h2 class="flex3"><?php echo $vehiculo->matricula;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Color:</h3>		<h2 class="flex3"><?php echo $vehiculo->color;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Precio Venta:</h3><h2 class="flex3"><?php echo $vehiculo->precio_venta;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Precio Compra:</h3><h2 class="flex3"><?php echo $vehiculo->precio_compra;?></h2></div>
					<div class="flex-container"><h3 class="flex1">KMS:</h3>			<h2 class="flex3"><?php echo $vehiculo->kms;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Caballos:</h3>	<h2 class="flex3"><?php echo $vehiculo->caballos;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Precio Venta:</h3><h2 class="flex3"><?php echo $vehiculo->precio_venta;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Año Matriculacion:</h3><h2 class="flex3"><?php echo $vehiculo->any_matriculacion;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Detalles:</h3>	<h2 class="flex3"><?php echo $vehiculo->detalles;?></h2></div>
					<br/>
					<input type="submit" name="modificar" value="Modificar estado"/><br/>    			
    			</form>
    			
    			<div class="imagen">
        			<figure>
            			<?php 
            			echo "<img src='$vehiculo->imagen' alt='Imagen de $vehiculo->modelo' title='Imagen de $vehiculo->modelo'/>";
            			echo "<figcaption>Imagen actual del modelo</figcaption>";
            			?>
            		</figure>
            	</div>	
        	</div>
        		
        	<p class="volver" onclick="history.back();">Atrás</p>	
			
		</section>
		
		<?php Template::footer();?>
    </body>
</html>