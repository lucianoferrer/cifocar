<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Detalles del vehiculo <?php echo $vehiculo->modelo;?></title>
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
			
			<h2>Detalles del vehiculo <?php echo $vehiculo->modelo;?></h2>
			
			<div class="contenedor">
    			<article class="texto">
					<div class="flex-container"><h3 class="flex1">Marca:</h3>		<h2 class="flex3"><?php echo $vehiculo->marca; ?></h2></div>
					<div class="flex-container"><h3 class="flex1">Modelo:</h3>		<h2 class="flex3"><?php echo $vehiculo->modelo;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Matricula:</h3>	<h2 class="flex3"><?php echo $vehiculo->matricula;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Color:</h3>		<h2 class="flex3"><?php echo $vehiculo->color;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Precio Venta:</h3><h2 class="flex3"><?php echo $vehiculo->precio_venta;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Precio Compra:</h3><h2 class="flex3"><?php echo $vehiculo->precio_compra;?></h2></div>
					<div class="flex-container"><h3 class="flex1">KMS:</h3>			<h2 class="flex3"><?php echo $vehiculo->kms;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Caballos:</h3>	<h2 class="flex3"><?php echo $vehiculo->caballos;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Precio Venta:</h3><h2 class="flex3"><?php echo $vehiculo->precio_venta;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Estado:</h3>		<h2 class="flex3">
    					<?php if ($vehiculo->estado==0) echo "En venta";
    					elseif ($vehiculo->estado==1) echo "Reservado";
    					elseif ($vehiculo->estado==2) echo "Vendido";
    					elseif ($vehiculo->estado==3) echo "Devolución";
    					elseif ($vehiculo->estado==4) echo "Baja";?></h2></div>
					<div class="flex-container"><h3 class="flex1">Año Matriculacion:</h3><h2 class="flex3"><?php echo $vehiculo->any_matriculacion;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Detalles:</h3>	<h2 class="flex3"><?php echo $vehiculo->detalles;?></h2></div>
					<div class="flex-container"><h3 class="flex1">Vendedor:</h3>	<h2 class="flex3"><?php echo $vendedorNombre;?></h2></div>
        		</article>
        		
        		<figure class="imagen">
        			<?php 
        			echo "<img src='$vehiculo->imagen' alt='Imagen de $vehiculo->modelo' title='Imagen de $vehiculo->modelo'/>";
        			echo "<figcaption>$vehiculo->modelo</figcaption>";
        			?>
        		</figure>	
    		</div>	
    		
    		<p class="volver" onclick="history.back();">Atrás</p>
    		
		</section>
		
		<?php Template::footer();?>
    </body>
</html>