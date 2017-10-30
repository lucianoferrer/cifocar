<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificar marca <?php echo $marca->marca;?></title>
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
			
			<h2>Modificar marca <?php echo $marca->marca;?></h2>
			
			<div class="contenedor">
    			<form class="texto" method="post" enctype="multipart/form-data" autocomplete="off">
    				
    				<label>Marca:</label>
    				<input type="text" name="marca" required="required"
    					value="<?php echo $marca->marca;?>" /><br/>
    				
    				<input type="submit" name="modificar" value="modificar"/><br/>
    			</form>
        	</div>
        		
        	<p class="volver" onclick="history.back();">Atrás</p>	
			
		</section>
		
		<?php Template::footer();?>
    </body>
</html>