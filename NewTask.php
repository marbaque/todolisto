<?php require_once("includes/dbconnect.php");?>
<?php require_once("includes/functions.php"); ?>
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
	
	if(isset($_GET['groupID'])){
		$currGroup = $_GET['groupID'];
	}
	
	
			
	//Retrieve the fields from the form
	if (isset($_POST['submit'])){
		$Title = htmlentities(stripslashes($_POST['title']));
		$GroupID = $_POST['the_group'];
		$Today = date("Y-m-d");
		$Deadline = $_POST['deadline'];
		//print_r($_POST); //dev only
		
		//escape all strings
		$Title = mysql_real_escape_string($Title, $DBConnect);
		
	
		//Perform the database query to create the new task
		$query = "INSERT INTO tasks (title, enter_date, deadline, userID, groupID) VALUES ('$Title', '$Today', '$Deadline', '$UserID', '$GroupID')";
		$result = mysql_query($query, $DBConnect);
		if ($result){
			//$Body.= "<div class='item alert'  align='center'><p>The task was successfully added!</p>";
			//$Body .= "<p><a class='button' href='index.php?" . SID ."'>Back to Task manager</a></p></a></div>";
			redirect_to("index.php?". SID);
		}
		else {
			//Failure
			$Body .= "Task creation failed";
			die("Database query failed. " . mysql_error($DBConnect));
		}
	}
	
?>

<?php	include("includes/head.php");?>
<body>
<div class="container">
	<div class="main" role="main">
		<div class="row">
			<div class="eight columns offset-by-two columns">
				<h2>Agregar una tarea</h2>
				<div class="form-box">
					<?php echo "<form method='post' action='NewTask.php?" . SID . "'>"; ?>
						<fieldset>
							<label for="title">Tengo que...</label>
							<input class="u-full-width" type="text" name="title" placeholder="Ej.: Comprar tiquete de avión" required><br>
							<label for="group_list">Asignar a un grupo</label>
							<select class="u-full-width" name="the_group" required>
								<?php 
									//select the records from groups database
									$GroupString = "SELECT * FROM groups WHERE userID = '$UserID'";
									$GroupsResult = mysql_query($GroupString, $DBConnect);
									if (!$GroupsResult){
										$Body .= "Error retrieving the groups list";
									}
									
									while ($Row = mysql_fetch_assoc($GroupsResult)){
										$Options[] = $Row;
									}
									
									foreach ($Options as $Option){
										echo "<option size=60 value=\"" . $Option['id'] . "\"";
										if ($Option['id']==$currGroup){
											echo " selected=\"selected\" ";
										}
										else{
											echo " ";
										}
										echo ">";
										echo $Option['group_title'];
										echo "</option>";
									}
									mysql_free_result($GroupsResult);	
								?>
								
							</select><br>
							
							<label for="deadline">Fecha (opcional):</label>
							
							<input class="u-full-width date" type="date" name="deadline" min="2015-08-18" max="2099-12-31" placeholder="0000-00-00"><br>
							
							<?php echo "<a href=\"index.php?" . SID . "\" class=\"button\">Cancelar</a>" ?>
							
							<input class="button-primary" type="submit" name="submit" value="Guardar">
						
						</fieldset>
					</form>
					<?php echo $Body; ?>
				</div>
			</div>
			
		</div><!-- Row ends here -->
	</div><!-- Main div ends here -->
</div><!-- Container ends here -->


<?php 
	
	//free the query result
	//mysql_free_result($result);
	//close database connection
	mysql_close($DBConnect); 
	?>
</body>
</html>