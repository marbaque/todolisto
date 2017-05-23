<?php require_once("includes/dbconnect.php");?>
<?php require_once("includes/functions.php") ?>
<?php
	session_start();
	if(isset($_SESSION['userID'])){
		$UserID = $_SESSION['userID'];
	}
	else{
		$UserID =-1;
		redirect_to("home.php");
	}

	//print_r($UserID);


	if (isset($_COOKIE['username'])){
		$UserName = $_COOKIE['username'];
	}
	else{
		$UserName = $_SESSION['name'];
	}


	include("includes/gravatar-inc.php");


	//Perform tasks database query from the groups table
	$GroupsQuery = "SELECT DISTINCT * FROM groups WHERE userID = '$UserID'";
	$GResult = mysql_query($GroupsQuery, $DBConnect);
	//Test if there was a query error
	if(!$GResult){
		die("Database failed to query.");
	}


?>
<?php	include("includes/head.php");?>
<body>
	<!-- header -->
	<header class="header">
		<div class="container">
		<h1 class="logo">Todo listo</h1>
		<nav class="usermenu" role="navigation">
			<ul>
				<?php
					//Shoe the main menu links
					echo "<li><a class=\"action-btn\" href=\"NewGroup.php?" . SID . "\"><i class=\"fa fa-folder-o\" aria-hidden=\"true\"></i> Grupo</a></li>";
					echo "<li><a class=\"action-btn\" href=\"NewTask.php?" . SID . "\"><i class=\"fa fa-list\" aria-hidden=\"true\"></i> Tarea</a></li>";
				?>
			</ul>
		</nav>
		</div>
	</header>
	<!-- header ends -->
	<div class="container">
	<div class="main" role="main">
	<?php
		echo "<div class=\"welcome\">
		<img class=\"userpic\" src=\"" .
		$avatarURL . "\" width=\"" .
		$avatarSize . "\" height=\"" .
		$avatarSize . "\" />

		Hola, <a href=\"profile.php?userID=$UserID" . SID . "\">" . $UserName . "

		<a class=\"logout\" href=\"home.php\">Cerrar sesión</a></div>";

		//Check if there are no records in groups table
		$countG = mysql_num_rows($GResult);
		if(!$countG){
			echo "<div class=\"item empty\">Comienza creando grupos. <a href=\"NewGroup.php?userID=$UserID\">¡Crea uno aquí!</a></div>";
		}

		//Use returned data to show the group title
		while($row = mysql_fetch_assoc($GResult)) {
			?>
			<div class="group">
			<?php
			//output data from each row
			$GroupTitle = $row['group_title'];
			$gID = $row['id'];

			//Perform tasks database query
			$TasksQuery = "SELECT * FROM tasks WHERE groupID = '{$gID}' ORDER BY deadline='0000-00-00', deadline ASC";
			$TResult = mysql_query($TasksQuery, $DBConnect);
			//Test if there was a query error
			if(!$GResult){
				die("Database failed to query.");
			}
			?> <!-- Escape PHP, Begin Html -->

			<!-- Show the group title -->
			<h4 class="group-title" id="<?php echo $gID ?>">
				<?php echo ucfirst($GroupTitle); ?>
				<span class="editmenu-g">
					<?php
						echo "<a href=\"EditGroup.php?" . SID . "&groupID=$gID\"><i class=\"fa fa-pencil fa-lg\"></i></i></a>";
						echo "<a href=\"DeleteGroup.php?" . SID . "&groupID=$gID\"><i class=\"fa fa-trash fa-lg\"></i></i></a>";
					?>
				</span>
			</h4>



			<?php
				//Check it the list returned no rows in a groupq
				$count = mysql_num_rows($TResult);
					if(!$count){
						echo "<div class=\"item empty\">";
						echo "No hay tareas en este grupo. <a href=\"NewTask.php?" . SID . "&groupID=$gID\">¡Agregue tareas aquí!</a>";
						echo "</div>";
					}
				//Create an array of the tasks into each group
				while ($row2 = mysql_fetch_assoc($TResult)){
				$CurrentTask = $row2['id'];
				$Complete = $row2['complete'];


				//If the deadline field is empty show 'Someday' or Tomorrow instead of 0000-00-00
				if ($row2['deadline'] == '0000-00-00'){
					$NewDate = "Eh.. algún día";
				}
				else{
					$RawDate = $row2['deadline'];
					$Date = strtotime($RawDate);
					$NewDate = date("M d, Y", $Date);
					if ($row2['deadline'] == date("Y-m-d", strtotime("tomorrow"))){
						$NewDate = "Mañana";
					}
					else if ($row2['deadline'] == date("Y-m-d", strtotime("today"))){
						$NewDate = "Hoy";
					}
					else if ($row2['deadline'] < date("Y-m-d", strtotime("yesterday"))){
						$NewDate = date("M d, Y", $Date) . "&nbsp;&nbsp;<strong><i class=\"fa fa-exclamation-circle\"></i></strong>";
					}
				}
			 ?>
			<section id="<?php echo $CurrentTask; ?>" class="item <?php
						if ($Complete == 1){
							echo "complete";
								}
						else{echo "";}
						?>">
				<div class="row">
					<div class="seven columns">
						<p class="task-title">
							<?php echo ucfirst($row2['title']); ?>
							<em class="deadline">— <i class="fa fa-calendar calendar" aria-hidden="true"></i>  <?php echo $NewDate; ?></em>
						</p>
					</div>
					<div class="five columns">
						<ul class="editmenu" >
							<li>
								<?php
									//checkbox button, check if the task is completed or not
									if ($Complete == 0){
										echo "<a href=\"CompleteTask.php?" . SID . "&task=$CurrentTask&check=1\"><i class=\"fa fa-check-circle-o fa-lg\" aria-hidden=\"true\"></i> Listo</a>";
									}
									if ($Complete == 1){
										echo "<a href=\"CompleteTask.php?" . SID . "&task=$CurrentTask&check=0\"><i class=\"fa fa-undo fa-lg\" aria-hidden=\"true\"></i> Deshacer</a>";
									}
									 ?>
									 		</li>
									<li><?php echo "<a class=\"edit\" href=\"EditTask.php?" . SID . "&taskID=$CurrentTask&groupID=$gID&date=$RawDate\"><i class=\"fa fa-pencil fa-lg\" aria-hidden=\"true\"></i> Editar</a>"; ?></li>
									<li><?php echo "<a class=\"delete\" href=\"DeleteTask.php?" . SID . "&taskID=$CurrentTask\"><i class=\"fa fa-trash  fa-lg\" aria-hidden=\"true\"></i> Borrar</a>"; ?>
								</li>
						</ul>

					</div>
				</div>
			</section>
	<?php

			}
			?>
			</div>
			<?php
				echo "<p align=\"center\"><a class=\"plus\" href=\"NewTask.php?" . SID . "&groupID=$gID\"><i class=\"fa fa-plus fa-lg\"></i></a></p>";
		}
		echo "</div>"; //<!-- container ends here -->"

		//Release returned data
		//mysql_free_result($GResult);
		//mysql_free_result($TResult);
		//close database connection
		mysql_close($DBConnect);
	?>
	</div>
<?php	include("includes/footer.php");?>
