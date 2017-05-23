<?php require_once("includes/dbconnect.php");?>
<?php require_once("includes/functions.php"); ?>
<?php
	session_start();
	
	$errors = 0;
	$Body= "";
	
	//Return the ID
	if(isset($_SESSION['userID']) && isset($_GET['groupID'])) {
		$UserID = $_SESSION['userID'];
		$GroupID = $_GET['groupID'];	
		//Retrieve current task records
		$queryCurr = "SELECT group_title FROM groups WHERE id=$GroupID AND userID=$UserID";
		$resultCurr = mysql_query($queryCurr, $DBConnect);
		if($resultCurr){
			$RowCurr = mysql_fetch_assoc($resultCurr);
			$CurrTitle = $RowCurr['group_title'];
		}
		
	}
	else{
		$UserID =-1;
		redirect_to("home.php");
	}
		
	//Retrieve the fields from the form
	if (isset($_POST['submit'])){
		$GroupName = htmlentities(stripslashes($_POST['title']));
		
		//escape string to avoid sql injection
		$GroupName = mysql_real_escape_string($GroupName, $DBConnect);
		
		//Retrieve the groups added by the currrent user ID
		//Perform the database query
		$string = "UPDATE groups SET group_title='$GroupName' WHERE userID='$UserID' AND id='$GroupID'";
		$result = mysql_query($string, $DBConnect);
		if ($result){
			$CurrTitle = $_POST['title'];
			//$Body.= "<div class='item alert'  align='center'><p>The group was successfully updated!</p>";
			//$Body .= "<p><a class='button' href='NewTask.php?" . SID . "'>Add tasks</a>"; 
			//$Body .= "<a class='button' href='index.php?" . SID . "'>Task manager</a></p></a></div>";
			redirect_to("index.php?". SID . "#" . $GroupID);
		}
		else {
			//Failure
			$Body .= "Group updating failed";
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
					<h2>Editar grupo</h2>
					<div class="form-box">
						<?php echo "<form method='post' action='EditGroup.php?" . SID . "&groupID=$GroupID'>"; ?>
							<fieldset>
								<label for="title">Nombre del grupo</label>
								<input class="u-full-width" type="text" name="title" value="<?php echo $CurrTitle; ?>" required><br>
								<?php echo "<a href=\"index.php?" . SID . "\" class=\"button\">Cancelar</a>" ?>
								<input class="button-primary" type="submit" name="submit" value="Actualizar">
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