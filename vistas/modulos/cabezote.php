 <header class="main-header">
	<!--=====================================
	LOGOTIPO
	======================================-->
	<a href="proveedores" class="logo">
		<!-- logo mini -->
		<span class="logo-mini">
			<img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding:10px">
		</span>
		<!-- logo normal -->
		<span class="logo-lg">
			<img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding:5px 15px">
		</span>
	</a>

	<!--=====================================
	BARRA DE NAVEGACIÓN
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Botón de navegación -->
	 	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	<span class="sr-only">Toggle navigation</span>
      	</a>
		<div class="navbar-custom-menu">		
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">			
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!-- Aquí mostramos el nombre del usuario desde la sesión -->
						<span class="hidden-xs">
							<?php
								// Si hay un nombre de usuario en la sesión, se muestra; de lo contrario, se muestra "Usuario"
								echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario';
							?>
							(
							<?php
								// Si hay un perfil en la sesión, se muestra; de lo contrario, se muestra "Sin perfil"
								echo isset($_SESSION['perfil']) ? htmlspecialchars($_SESSION['perfil']) : 'Sin perfil';
							?>
							) conectado.
						</span>

					</a>
					<!-- Dropdown-toggle -->
					<ul class="dropdown-menu">
						<li class="user-body">
							<div class="text-center"> <!-- Cambiamos la clase para centrar -->
								<a href="salir" class="btn btn-default btn-flat">Salir</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
 </header>