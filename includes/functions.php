<?php
 	//redirect
	function redirect_to($new_location){
		header("Location: " . $new_location);
		exit;
	}

	function update_check($i, $u, $t, $DB){
		$string = "UPDATE tasks SET complete=$i WHERE userID=$u AND id=$t";
		$result= mysql_query($string, $DB);
		if(!$result){
			die ("Check complete failed");
		}
	}


?>
