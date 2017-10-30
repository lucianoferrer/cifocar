<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificación de datos de usuario</title>
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
<!-- 			<a class="derecha" href='index.php?controlador=Receta&operacion=borrar&parametro=$receta->id'><img class='boton' src='images/buttons/delete.png' alt='borrar' title='borrar'/></a></td>"; -->

			<a class="derecha" href="index.php?controlador=Usuario&operacion=baja&parametro=<?php echo $usuarioCifocar->user;?>">
				<img src="images/buttons/delete.png" alt="dar de baja al usuario" class="logo" />
				Dar de baja al usuario
			</a>
			
			<h2>Formulario de modificación de datos</h2>
			
			<form method="post" enctype="multipart/form-data" autocomplete="off">
				
				<figure>
					<img class="imagenactual" src="<?php echo $usuarioCifocar->imagen;?>" 
						alt="<?php echo  $usuarioCifocar->user;?>" />
				</figure>
				
				
				<label>User:</label>
				<input type="text" name="user" required="required" 
					readonly="readonly" value="<?php echo $usuarioCifocar->user;?>" /><br/>
			
				<label>Nuevo password:</label>
				<input type="password" name="newpassword" pattern=".{4,16}" title="4 a 16 caracteres"/>
				<span class="mini">En blanco para no modificar el actual</span><br/>
				
				<label>Nombre:</label>
				<input type="text" name="nombre" required="required" 
					value="<?php echo $usuarioCifocar->nombre;?>"/><br/>
			
			<?php if ($usuarioCifocar->privilegio==0){
			         $s0='selected';$s1='';$s2='';
			     }elseif($usuarioCifocar->privilegio==1){
		             $s0=''; $s1='selected';$s2='';;
		         }else{
		             $s0='';$s1='';$s2='selected';
		         }?>
			<label>Privilegio:</label>
				<select id="privilegio" name="privilegio">
                  <option value="0" <?php echo $s0;?>>Admin</option>
                  <option value="1" <?php echo $s1;?>>Compras</option>
                  <option value="2" <?php echo $s2;?>>Vendedor</option>
				</select>
				</br>
								
				<label>Email:</label>
				<input type="email" name="email" required="required" 
					value="<?php echo $usuarioCifocar->email;?>"/><br/>
				<?php $usuarioCifocar->admin==0?$ad="value=0 ":$ad="value='1' checked='checked' ";?>
				<label>Admin:</label>
				<input type="checkbox" name="admin" <?php echo $ad;?>"/><br/>
				
				<label>Nueva imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_image_size;?>" />		
				<input type="file" accept="image/*" name="imagen" />
				<span class="mini">max <?php echo intval($max_image_size/1024);?>kb</span><br />
				
				<label></label>
				<input type="submit" name="modificar" value="modificar"/><br/>
			</form>
			
				
		</section>
		
		<?php Template::footer();?>
    </body>
</html>