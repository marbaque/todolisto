<?php
	function validateRegister(){
		require_once("includes/dbconnect.php");
		//session_start();
		//setting the variable for the alerts
		$Body = "";
		$errors = 0;
		$email = "";

		//validate email field
		if (empty($_POST['email'])) {
			++$errors;
			$Body .= "<div class=\"alert\">Tiene que ingresar una dirección de correo.</div>\n";
		}
		else {

			$email = test_input($_POST['email']);
			//As seen in http://www.w3schools.com/php/php_form_url_email.asp
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				++$errors;
				$Body .= "<div class=\"alert\">Necesita una dirección de correo válida.</div>\n";
				$email = "";
			}
		}

		//validate password
		if (empty($_POST['password'])) {
			++$errors;
			$Body .= "<div class=\"alert\">Debe escribir una contraseña.</div>\n";
			$password = "";
		}
		else
			$password = stripslashes($_POST['password']);
		//Confirm password
		if (empty($_POST['password2'])) {
			++$errors;
			$Body .= "<div class=\"alert\">Debe confirmar la contraseña.</div>\n";
			$password2 = " ";

		}
		else
			$password2 = stripslashes($_POST['password2']);

		//Verify that the password fields are not empty
		if ((!(empty($password))) && (!(empty($password2)))) {
			if (strlen($password) < 7) {
				++$errors;
				$Body .= "<div class=\"alert\">La contraseña es muy corta.</div>\n";
				$password = "";
				$password2 = "";
			}
			//if not empty check if they match
			if ($password <> $password2){
				++$errors;
				$Body .= "<div class=\"alert\">Las contraseñas no son iguales.</div>\n";
				$password = "";
				$password2 = "";
			}
		}

		//check that the email is not already in the db table
		if ($errors == 0){
			$query = "SELECT * FROM users WHERE email = '$email'";
			$result = mysql_query($query, $DBConnect);
			while ($row = mysql_fetch_array($result)) {
				if ($row[0]>0){
					++$errors;
					$Body .= "<div class=\"alert\">Esa dirección de correo ya está en uso. <a href='Login.php'>Intente ingresar</a>.</div>";
				}
			}
			//mysql_free_result($result);
		}

		//show the message if there are errors
		if ($errors > 0) {
			$Body .= "<div class='alert'>Vuelva a intentarlo.</div>\n";
		}

		//add the user to the db
		//an MD5 hash of the password is stored in the database for security reasons.
		if ($errors == 0) {
			$first = test_input($_POST['first']);
			$last = test_input($_POST['last']);
			$date = date("Y-m-d");
			$SQLString = "INSERT INTO users (first, last, email, password_md5, register_date)";
			$SQLString .= "VALUES('$first', '$last', '$email', '" . md5($password) . "', '$date')";
			$QueryResult = mysql_query($SQLString, $DBConnect);

			if ($QueryResult === FALSE){
				$Body .= "<div class=\"alert\">No es posible registrar su cuenta. Error code " . mysql_errno($DBConnect) . ": " . mysql_error($DBConnect) . "</div>\n";
				++$errors;
			}
			else {
				$_SESSION['userID'] = mysql_insert_id($DBConnect);
				$_SESSION['name'] = ucfirst($first) . " " . ucfirst($last);
				//$Body .= $_SESSION['userID'] . " " . $_SESSION['name'];
			}
			setcookie("username", $UserName, time()+60*60*24*7);

			//mysql_free_result($QueryResult);
			mysql_close($DBConnect);
		}

		//load the task manager link if there were no errors and pass the user id using Get
		if ( $errors == 0 ) {
			//$Body .= "passsssss";
			echo "<script>location='index.php'</script>" . SID;
			exit;
		}
		echo $Body;
	}

	// Sanitize data
	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

?>
