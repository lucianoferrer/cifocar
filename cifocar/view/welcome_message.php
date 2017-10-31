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

// 			if(!$usuario) Template::login(); //pone el formulario de login
// 			else Template::logout($usuario); //pone el formulario de logout
			
//			Template::menu($usuario); //pone el menú
		?>

		<section id="content">
			<div class="welcome">
    			<h1>Portal de acceso a Cifocar</h1>
    			<h2>Por favor, identifícate.</h2>
    			<form method="post"  autocomplete="off">
    				<input type="text" placeholder="usuario" name="user" required="required" /><br/>
    				<input type="password" placeholder="clave" name="password" required="required"/><br/>
    				<input type="submit" name="login" value="Login" />
    			</form>
			</div>
		</section>
		
		<?php Template::footer();?>
    </body> 
</html>