<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Portada</title>
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
			<h2>Presentación</h2>
			<p> Bienvenido, <?php echo $usuario->nombre?>.</p>
			<p> A partir de ahora este será tu punto de inicio en tu labor díaria.</p>
			<p> Aquí podrás encontrar las noticias más relevantes de nuestras empresa 
			y todas aquellas promociones que te permitirán mejorar en tu trabajo</p>
			<p> También es un punto de encuentro con tus compañeros donde podrás intercambiar
			news y opiniones
			

		</section>
		
		<?php Template::footer();?>
    </body> 
</html>