<?php
	session_start();
	include("includes/head.php");
	include("ValidateRegister.php");

?>
	<body>
		<header class="header">
			<div class="container" align="center">
			<a href="home.php" title="inicio"><h1 class="logo">Todo listo</h1></a>
			</div>
		</header>

		<div class="container">

			<div class="main">
				<div class="row">
					<div class="six columns offset-by-three">
						<h4>Registrarse</h4>
						<form class="form-box" method="post" action="">
							<fieldset>
								<label for="first">Nombre</label>
								<input class="u-full-width" type="text" name="first" placeholder="Ej: Jorge Luis" autofocus required><br>
								<label for="last">Apellido</label>
								<input class="u-full-width" type="text" name="last" placeholder="Ej: Borges"><br>
								<label for="email">Correo</label>
								<input class="u-full-width" type="email" name="email" placeholder="correo@ejemplo.com"><br>
								<label for="password">Crear contraseña</label>
								<input class="u-full-width" type="password" name="password" required="required"><br>
								<label for="password2">Confirmar contraseña</label>
								<input class="u-full-width" type="password" name="password2" required="required"><br>
								<input class="button" type="submit" name="submit" value="Registrarse">
							</fieldset>
							<?php
								//if the form is sent
								if ($_SERVER['REQUEST_METHOD']== "POST"){
									validateRegister();
								}
							 ?>
						</form>
						<p>¿Ya se registró antes? <a href="Login.php">Ingrese aquí</a></p>
					</div>

				</div><!-- Row ends here -->
			</div> <!-- Main ends here -->
		</div><!-- Container ends here -->

	</body>

</html>
