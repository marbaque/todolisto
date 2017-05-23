<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/dbconnect.php"); ?>
<?php 
	session_start();
	// get id values for user and the task
	if (isset($_SESSION['userID']) && isset($_GET['groupID'])) {
		$UserID = $_SESSION['userID'];
		$GroupID = $_GET['groupID'];
		// delete the entry
		$string = "DELETE FROM groups WHERE id=$GroupID AND userID=$UserID";
		$result = mysql_query($string, $DBConnect);
		if(!$result){
			die("Delete failed.");
		}else{
			redirect_to("index.php?" . SID);
		}
		mysql_free_result($result);
	}
	
?>



