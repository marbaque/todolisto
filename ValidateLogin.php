
<?php
	//validate the login form
	function validateLogin(){
		require_once("includes/dbconnect.php");

		session_start();
		$errors = 0;
		$Body = "";


		//verify that the e-mail address and password entered are in the users table
		//the MD5 hash of the password is stored in the database, not the password itself.

		if ($errors === 0) {
			//check if the email and password match to the fields in the db
			$SQLstring = "SELECT * FROM users WHERE email='" . test_input($_POST['email']) . "' and password_md5='" . md5(test_input($_POST['password'])) . "'";
			$QueryResult = mysql_query($SQLstring, $DBConnect);



			if (mysql_num_rows($QueryResult)==0) {
				$Body .= "<div class=\"alert\">La dirección de correo y el password no coinciden.</div>\n";
				++$errors;
			}
			else{

				$Row = mysql_fetch_assoc($QueryResult);
				//Save the data in the session
				$_SESSION['userID'] = $Row['id'];
				$_SESSION['name'] = ucfirst($Row['first']) . " " . ucfirst($Row['last']);
				//$Body .= "<p>Welcome back, " . $_SESSION['name'] . "!</p>\n";
				//Redirect to the task manager or home page if there is no error.
				if ($errors === 0) {
					echo "<script>location='index.php'</script>" . SID;
					exit;
				}
			}


		}

		if ($errors > 0) {
			$Body .= "<div class=\"alert\">Corrija los errores indicados.</div>\n";
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
