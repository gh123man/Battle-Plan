<?php

include_once "./pageElements/headder.php";
include_once "./utils/helpers.php";
?>
<LINK href="/static/css/pageContent.css" rel="stylesheet" type="text/css">
<LINK href="/static/css/task.css" rel="stylesheet" type="text/css">
<body>
<div class="pageContent">

<?php
include_once "./objects/Task.php";
include_once "./objects/Project.php";
include_once "./pageElements/tasks.php";
if (isset($_GET['ID']) && Task::taskExistsId($_GET['ID'])) {
    
    $task = new Task($_GET['ID']);
    $project = new Project($task->getProject());
    if ($_SESSION['account']->getID() != $project->getOwner()) {
        taskNotExist();
        return;
    }
    varJS("ID", $task->getID());
} else {
    taskNotExist();
    return;
}

?>


<div class="projectTitle">
     <a href="/project?ID=<?php echo $project->getID();?>">
    <span>
        <?php echo $project->getName();?>
    </span>
    </a>
</div>


<div class="navigatonList">
    <a href="/allTasks.php?ID=<?php echo $project->getID();?>">
    <?php echo $project->getName();?>
    </a>
    <?php drawNavigaiton($task->getID()); ?>
</div>


<?php

showTaskNode($task);
createTaskWindow();



?>


</div>
</body>
<?php

include_once "pageElements/footer.php";

?>
