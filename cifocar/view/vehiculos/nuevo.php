<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Nuevo vehículo</title>
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
			<h2>Nuevo vehículo</h2>
			<form method="post" enctype="multipart/form-data" autocomplete="off">
				<label>Marca:</label>
				<select name="marca" required>
				<?php foreach($marcas as  $marca)
                        echo "<option value='$marca->marca'>$marca->marca</option>";?>
		        </select>
				
				<br/><label>Modelo:</label>
				<input type="text" name="modelo" required="required"/><br/>
				<label>Matrícula:</label>
				<input type="text" name="matricula" pattern= "[0-9]{4}\W[A-Za-z]{3}$" title="4 números y tres letras separados por un guion o espacio" placeholder="0000-XXX" required="required"/><br/>
				<label>Color:</label>
				<input type="text" name="color" required="required"/><br/>
				<label>Precio Venta:</label>
				<input type="number" name="precio_venta" required="required"/><br/>
				<label>Precio Compra:</label>
				<input type="number" name="precio_compra" required="required"/><br/>
				<label>KMS:</label>
				<input type="number" name="kms" required="required"/><br/>
				<label>Caballos:</label>
				<input type="number" name="caballos" required="required"/><br/>
				<label>Estado:</label>
				<select name="estado" required>
                    <option value="0" selected="selected">En venta</option>
                    <option value="1">Reservado</option>
                    <option value="2">Vendido</option>
                    <option value="3">Devolución</option>
                    <option value="2">Baja</option>
				</select>
				<br/>
				<label>Año Matriculación:</label>
				<input type="number" name="any_matriculacion" required="required"/><br/>
				<label>Detalles:</label>
				<textarea name="detalles"></textarea><br/>

				<label>Imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_image_size;?>" />		
				<input type="file" accept="image/*" name="imagen" required/>
				<span>max <?php echo intval($max_image_size/1024);?>kb</span><br />

				<input type="submit" name="guardar" value="guardar"/><br/>
			</form>
			
			<p class="volver" onclick="history.back();">Atrás</p>
			
		</section>
		
		<?php Template::footer();?>
    </body>
</html>