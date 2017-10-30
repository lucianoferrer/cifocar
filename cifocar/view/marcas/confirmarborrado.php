<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Confirmar borrado de <?php echo $marca->marca;?></title>
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
			<h2>Confirmar borrado de la marca:</h2>
			<div class="contenedor">
				<div class="texto">
        			<h3>Marca</h3> <?php echo $marca->marca?>
        			<form method="POST">
        				<label>Estas seguro?</label>
        				<input type="submit" name="confirmarborrado" value="Confirmar" />
        				<input type="button" onclick="history.back();" value="Cancelar"/>
        			</form>
    			</div>
    		</div>
    		<p class="volver" onclick="history.back();">Atrás</p>
		</section>
		<?php Template::footer();?>
    </body>
</html>