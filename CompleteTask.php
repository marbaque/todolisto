<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/dbconnect.php"); ?>
<?php
	session_start();
	// get id values for user and the task
	if (isset($_SESSION['userID']) && isset($_GET['task']) && isset($_GET['check'])) {
		$UserID = $_SESSION['userID'];
		$TaskID = $_GET['task'];
		$Complete = $_GET['check'];
		// update the complete field
		$string = "UPDATE tasks SET complete=$Complete WHERE id=$TaskID AND userID=$UserID";
		$result = mysql_query($string, $DBConnect);
		if(!$result){
			die("Delete failed.");
		}else{
			//redirect_to("index.php?" . SID . "#" . $TaskID);
			redirect_to("location.href=document.referrer" . SID . "#" . $TaskID);
		}
		mysql_free_result($result);
	}

?>
