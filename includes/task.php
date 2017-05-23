<?php
//function to check a task done or undone
include("../CompleteTask.php");
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
            <nav><ul class="editmenu" >
                <li>

                <!-- checkbox button, check if the task is completed or not -->
                <form method="get" action="">
                    <input type="hidden" name="get_check">
                    <input type="submit">
                    <?php
                    //when the form is submitted
                    if(isset($_GET['get_check'])) {
                        print_r($CurrentTask);
                        if ($Complete === 0){
                            CompleteTask($CurrentTask,1);
                        }else {
                            CompleteTask($CurrentTask,0);
                        }
                    }

                     ?>
                </form>

                </li>

                <li><?php echo "<a class=\"edit\" href=\"EditTask.php?" . SID . "&taskID=$CurrentTask&groupID=$gID&date=$RawDate\"><i class=\"fa fa-pencil fa-lg\" aria-hidden=\"true\"></i> Editar</a>"; ?></li>
                    <li><?php echo "<a class=\"delete\" href=\"DeleteTask.php?" . SID . "&taskID=$CurrentTask\"><i class=\"fa fa-trash  fa-lg\" aria-hidden=\"true\"></i> Borrar</a>"; ?>
                </li>
            </ul></nav>
        </div>
    </div>
</section>
<?php

}
?>
