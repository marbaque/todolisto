<?php
	//connect to the db server and uptodo_taskmanager db

	$DBConnect = @mysql_connect("localhost", "root", "root");
	$DBName = "uptodo_taskmanager";
	$result = @mysql_select_db($DBName, $DBConnect);



?>