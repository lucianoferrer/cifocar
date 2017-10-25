<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Baja de usuarios</title>
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
			<h2>Formulario de baja de usuario</h2>
			<p>Por favor, confirma tu solicitud de baja introduciendo el password asociado a tu cuenta.</p>
		
			<form method="post" autocomplete="off">
				<label>User:</label>
				<input type="text" readonly="readonly" value="<?php echo $usuario->user;?>" /><br/>
				
				<label>Password:</label>
				<input type="password" name="password" required="required"/><br/>
				
				<label></label>
				<input type="submit" name="confirmar" value="Confirmar"/><br/>
			</form>
		</section>
		
		<?php Template::footer();?>
    </body>
</html>