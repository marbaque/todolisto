<?php require_once("includes/dbconnect.php");?>
<?php require_once("includes/functions.php"); ?>
<?php
	session_start();
	$errors = 0;
	$Body= "";
	
	//Return the ID
	if(isset($_SESSION['userID']) && isset($_GET['taskID'])) {
		$UserID = $_SESSION['userID'];
		$TaskID = $_GET['taskID'];
		//Retrieve current task records
		$queryCurr = "SELECT title, deadline FROM tasks WHERE id=$TaskID AND userID=$UserID";
		$resultCurr = mysql_query($queryCurr, $DBConnect);
		if($resultCurr){
			$RowCurr = mysql_fetch_assoc($resultCurr);
			$CurrTitle = $RowCurr['title'];
			$CurrDate = $RowCurr['deadline'];
		}
	}
	else{
		$UserID =-1;
		redirect_to("index.php");
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
		
		
		//escape all strings to avoid injection
		$Title = mysql_real_escape_string($Title);
		
		//Perform the database query to update the current task
		$string = "UPDATE tasks SET title='$Title', deadline='$Deadline', groupID=$GroupID WHERE userID='$UserID' AND id='$TaskID'";
		$result = @mysql_query($string, $DBConnect);
		if ($result){
			$CurrTitle = $Title;
			//$Body.= "<div class='item alert'  align='center'><p>The task was successfully updated!</p>";
			//$Body .= " <a class='button' href='index.php?" . SID . "'>Back to Task manager</a></div>";
			redirect_to("index.php?". SID . "#" . $TaskID);
		}
		else {
			//Failure
			$Body .= "Task update failed";
			die("Database query failed. " . mysql_error($DBConnect));
		}
		//free the query result
		mysql_free_result($result);
	}
	
	//If the deadline field is empty show 'Someday' instead of 0000-00-00
	if ($_GET['date'] == 0000-00-00){
		$Date = date("yy-mm-dd");
	}
	else{
		$Date = $_GET['date'];
	}
?>
<?php	include("includes/head.php");?>
<body>
	<div class="container">
		<div class="main" role="main">
			<div class="row">
				<div class="eight columns offset-by-two columns">
					<h2>Editar tarea</h2>
					<div class="form-box">
						<?php echo "<form method='post' action='EditTask.php?" . SID ."&taskID=$TaskID'>"; ?>
							<fieldset>
								<label for="title">Tengo que...</label>
								<input class="u-full-width" type="text" name="title" value="<?php echo $CurrTitle; ?>" placeholder="Ej.: Planear vacaciones" required><br>
								<label for="group_list">Asignar a un grupo</label>
								<select class="u-full-width" name="the_group" required>
									<?php 
										//select the records from groups database to show in the select box
										$GroupString = "SELECT DISTINCT * FROM groups WHERE userID = '$UserID'";
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
								
								<label for="deadline">Due date (optional):</label>
								
								<input class="u-full-width date" type="date" name="deadline" value="<?php echo $CurrDate; ?>" min="2015-08-18"><br>
								
								<?php echo "<a href=\"index.php?" . SID . "\" class=\"button\">Cancelar</a>" ?>
								
								<input class="button-primary" type="submit" name="submit" value="Actualizar">
							
							</fieldset>
						</form>
						<?php echo $Body; ?>
					</div>
					
				</div>
				
			</div><!-- Row ends here -->
		</div><!-- Main div ends here -->
	</div><!-- Container ends here -->
	
	<?php 
		//mysql_free_result($resultCurr);
		
		//close database connection
		mysql_close($DBConnect); 
		?>
	
</body>
</html>