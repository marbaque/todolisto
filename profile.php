<?php require_once("includes/dbconnect.php");?>
<?php require_once("includes/functions.php"); ?>
<?php
	session_start();
	$errors = 0;
	$Body= "";

	//Return the ID
	if(isset($_SESSION['userID'])) {
		$UserID = $_SESSION['userID'];
		//Retrieve current user records
		$queryUser = "SELECT * FROM users WHERE id=$UserID";

        $resultUser = mysql_query($queryUser, $DBConnect);

        if($resultUser){
			$RowUser = mysql_fetch_assoc($resultUser);
			$UserFirst = $RowUser['first'];
			$UserLast = $RowUser['last'];
            $UserEmail = $RowUser['email'];
			$RegDate = date("d F, Y", $RowUser['register_date']);
            //print("Mi nombre es:" . $UserFirst);
		}
	}
	else{
		$UserID =-1;
		redirect_to("index.php");
	}

    // The users email, passed to Gravatar
	//$usersEmail = "";

	// A default avatar to load if Gravatar
	// doesn't find one.
	//$defaultImage = "http://todolisto.net/images/icon-user.png";

	// The size of the image
	$avatarSize = "150";

	// Minimum rating for your site
	// Possible values (G, PG, R, X)
	$avatarRating = "PG";

	// Border around the image
	$avatarBorder = "000000";

	// URL for Gravatar
	$gravatarURL = "http://www.gravatar.com/avatar.php?gravatar_id=%s
	&default=%s&size=%s&border=%s&rating=%s";

	$avatarURL = sprintf
	(
		$gravatarURL,
		md5($UserEmail),
		$defaultImage,
		$avatarSize,
		$avatarBorder,
		$avatarRating
	);



?>
<?php include("includes/head.php");?>
<body>
    <!-- header -->
    <header class="header" aria-role="banner">
  		<div class="container">
  			<a href="index.php" title="Regresar al administrador"><h1 class="logo" >Todo listo</h1></a>
  		</div>
  	</header>
	<!-- header ends -->
	<div class="container">
		<div class="main" role="main">
			<div class="row">
				<a class="button" href="index.php" title="Regresar al administrador"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			</div>
			<div class="row">
				<div class="eight columns">
					<h2>Datos personales</h2>
					<div class="form-box info-box">
                        <!-- gravatar image -->
						<div class="gravatar">
							<a href="https://es.gravatar.com/" title="Crear cuenta de Gravatar" target="blank"><?php echo "<img src=\"" . $avatarURL . "\" width=\"" . $avatarSize . "\" height=\"" . $avatarSize . "\" />"; ?></a>
						</div>
                        <!-- gravatar image -->
						<table class="u-full-width">
							<tbody>
								<tr>
									<td><strong>Nombre</strong></td>
									<td><?php echo $UserFirst . " " . $UserLast; ?></td>
								</tr>
								<tr>
									<td><strong>Email</strong></td>
									<td><?php echo $UserEmail; ?></td>

								</tr>
								<tr>
									<td><strong>Contraseña</strong></td>
									<td>*************</td>
								</tr>
								<tr>
									<td><strong>Fecha de registro</strong></td>
									<td><?php echo $RegDate; ?></td>
								</tr>
							</tbody>
						</table>
						<?php echo $Body; ?>
					</div>

				</div>
                <div class="four columns">
                    <nav class="info-sidebar">
                        <ul>
                            <li>Editar información personal (en construcción)</li>
							<li><a href="https://signup.wordpress.com/signup/?ref=oauth2&oauth2_redirect=b47623e486c7b82e3a86d6f3756358b9%40https%3A%2F%2Fpublic-api.wordpress.com%2Foauth2%2Fauthorize%2F%3Fclient_id%3D1854%26response_type%3Dcode%26blog_id%3D0%26state%3Da19a051ff0f0cc4c50d04f24a5ebf6ce6cfa896f677883953524b41ea4dbb89b%26redirect_uri%3Dhttps%253A%252F%252Fen.gravatar.com%252Fconnect%252F%253Faction%253Drequest_access_token%26jetpack-code%26jetpack-user-id%3D0%26action%3Doauth2-login&wpcom_connect=1" title="Crear mi propio Gravatar" target="blank">Cear mi propio Gravatar</a></li>
							<li><a href="https://en.gravatar.com/support/what-is-gravatar/" title="Gravatar" target="blank">¿Qué es un Gravatar?</a></li>
                            <li><a class="logout" href="home.php">Cerrar sesión</a></li>
                        </ul>
                    </nav>
                </div>

			</div><!-- Row ends here -->
		</div><!-- Main div ends here -->
	</div><!-- Container ends here -->

	<?php
		//mysql_free_result($resultCurr);

		//close database connection
		mysql_close($DBConnect);
		?>

<?php include_once("includes/footer.php") ?>
