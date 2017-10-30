<?php
	class Template{	
		
		//PONE EL HEADER DE LA PAGINA
		public static function header(){	?>
			<header>
				<figure>
					<a href="index.php">
						<img alt="logo concesionario Cifocar" src="images/logos/logo.png" />
					</a>
				</figure>
				<hgroup>
					<h1>Concesionario Cifocar</h1>
					<h2>Desarrollo proyecto fin curso</h2>
				</hgroup>
			</header>
		<?php }
		
		//PONE EL FORMULARIO DE LOGIN
		public static function login(){?>
			<form method="post" id="login" autocomplete="off">
				<input type="text" placeholder="usuario" name="user" required="required" />
				<input type="password" placeholder="clave" name="password" required="required"/>
				<input type="submit" name="login" value="Login" />
			</form>
		<?php }
		
		//PONE LA INFO DEL USUARIO IDENTIFICADO Y EL FORMULARIOD DE LOGOUT
		public static function logout($usuario){	?>
			<div id="logout">
				<span>Hola 
					<a href="index.php?controlador=Usuario&operacion=modificacion" title="modificar datos">
					<?php echo $usuario->nombre;?></a>
					<?php if ($usuario->privilegio==0) $rol="Admin";
					      elseif($usuario->privilegio==1) $rol="Rble. de compras";
	                      else $rol="Vendedor";
                          echo ', tienes el rol de ' . $rol;
                          if($usuario->admin) echo ', y eres administrador';?>
				</span>
				<form method="post">
					<input type="submit" name="logout" value="Logout" />
				</form>
			</div>
		<?php }
		
		//PONE EL MENU DE LA PAGINA
		public static function menu($usuario){ ?>
			<nav>
				<ul class="menu">
					<li><a href="index.php">Inicio</a></li>
					<li><a href="index.php?controlador=Vehiculo&operacion=listar">Listado de Vehículos</a></li>
					<?php if($usuario && $usuario->privilegio==1)
					    echo '<li><a href="index.php?controlador=Vehiculo&operacion=registrar">Nuevo Vehículo</a></li> ';
                        echo '<li><a href="index.php?controlador=Marca&operacion=listar">Marcas</a></li> ';?>
					    </ul>
				<?php 
				//pone el menú del administrador
				if($usuario && $usuario->admin){	?>
				<ul class="menu">
					<li><a href="#">ADMIN</a></li>
					<li><a href="index.php?controlador=Usuario&operacion=registro">Nuevo usuario</a></li>
					<li><a href="index.php?controlador=Usuario&operacion=listar">Usuarios</a></li>
					<li><a href="index.php?controlador=Vehiculo&operacion=listarAdmin">Vehiculos</a></li>
				</ul>
				<?php }	?>
			</nav>
		<?php }
		
		//PONE EL PIE DE PAGINA
		public static function footer(){	?>
			<footer>
				<p>Herramienta de gestión de Cifocar</p>
			</footer>
		<?php }
	}
?>