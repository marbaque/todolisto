<?php require_once("includes/functions.php");?>
<?php require_once("includes/dbconnect.php");?>
<?php
	session_start();
	$errors = 0;
	$Body= "";
	
	//Return the ID
	if(isset($_SESSION['userID'])){
		$UserID = $_SESSION['userID'];
	}
	else{
		$UserID =-1;
		redirect_to("home.php");
	}
		
	//Retrieve the fields from the form
	if (isset($_POST['submit'])){
		$GroupTitle = htmlentities(stripslashes($_POST['group_title']));
		$Today = date("Y-m-d");
		//escape string title
		$GroupTitle = mysql_real_escape_string($GroupTitle, $DBConnect);
		
		//Retrieve the groups added by the currrent user ID
		//Perform the database query
		$query = "INSERT INTO groups (group_title, group_date, userID) VALUES ('{$GroupTitle}', '{$Today}', '{$UserID}')";
		$result = mysql_query($query, $DBConnect);
		if ($result){
			//Success. Show link to task manager in index.php
			//$Body.= "<div class='item alert'  align='center'><p>The group was successfully added!</p>";
			//$Body .= "<p><a class='button' href='NewTask.php?" . SID . "'>Add tasks</a>"; 
			//$Body .= "<a class='button' href='index.php?" . SID . "'>Task manager</a></p></a></div>";
			redirect_to("index.php?SID");
		}
		else {
			//Failure
			$Body .= "Group creation failed";
			die("Database query failed. " . mysql_error($DBConnect));
		}
	}
?>
<?php	include("includes/head.php");?>
<body>
	<div class="container">
		<div class="main" role="main">
			<div class="row">
				<div class="six columns offset-by-three columns">
					<h2>Crear un grupo nuevo</h2>
					<div class="form-box">
						<?php echo "<form method='post' action='NewGroup.php?" . SID . "'>"; ?>
							<fieldset>
								<label for="group_title">Nombre del grupo</label>
								<input class="u-full-width" type="text" name="group_title" required><br>
								<?php echo "<a href=\"index.php?" . SID . "\" class=\"button\">Cancelar</a>" ?>
								<input class="button-primary" type="submit" name="submit" value="Guardar">
							</fieldset>
						</form>
						<?php echo $Body; ?>
					</div><!-- Form box ends here -->
				</div>
			</div><!-- Row ends here -->
		</div>
	</div><!-- Container ends here -->
	
	<?php 
		
		//free the query result
		//mysql_free_result($result);
		//close database connection
		mysql_close($DBConnect); 
		?>
</body>
</html>