<?php include("includes/head.php"); ?>
<?php include("ValidateLogin.php"); ?>
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
						<h4>Ingresar</h4>
						<form class="form-box" method="post" action="">
							<fieldset>
								<label for="email">Correo</label>
								<input class="u-full-width" type="email" name="email" autofocus="autofocus" placeholder="sucorreo@ejemplo.com"><br>
								<label for="password">Contraseña</label>
								<input class="u-full-width" type="password" name="password"><br>
								<input class="button" type="submit" name="submit" value="Ingresar">
							</fieldset>
							<?php
								//if the form is sent
								if ($_SERVER['REQUEST_METHOD']== "POST"){
									validateLogin();
								}
							 ?>
						</form>

						<p>¿No tiene una cuenta? <a href="Register.php">Regístrese aquí</a>.</p>
					</div>
				</div><!-- Row ends here -->
			</div>
		</div><!-- Container ends here -->
	</body>
</html>
