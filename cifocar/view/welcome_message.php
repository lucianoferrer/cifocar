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
			<p>Este framework para PHP ha sido desarrollado con fines docentes para el CP de 
			<b>desarrollo de aplicaciones con tecnologías web</b> (IFCD0210) que imparte <b>Robert Sallent</b>.</p>
			
			<p>Es un ejemplo de <b>arquitectura modelo-vista-controlador con controlador frontal</b> para entender los
			conceptos y poder trabajar. Además combina una parte de administración sencilla mediante interfaz gráfica, 
			como si se tratara de un CMS, para lo que requiere de una base de datos.</p>
			
			<p>A lo largo del curso se desarrollan varios proyectos de ejemplo usando este pequeño framework,
			para ir entendiendo los conceptos básicos comunes a este tipo de herramientas de trabajo. 
			En el mismo curso, en el último módulo, utilizamos también CodeIgniter para desarrollos más complejos
			usando la misma arquitectura.</p>
			
			<p><b>NO ES 100% SEGURO</b>, así que no se debe usar para desarrollos en entornos de producción. Para cualquier duda
			o consulta,	contactad conmigo mediante twitter.</p>
		</section>
		
		<?php Template::footer();?>
    </body> 
</html>