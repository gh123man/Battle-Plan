<?php

include_once "./pageElements/headder.php";
?>
<LINK href="/static/css/pageContent.css" rel="stylesheet" type="text/css">
<LINK href="/static/css/project.css" rel="stylesheet" type="text/css">
<body>
<div class="pageContent">

<?php
include_once "./objects/Project.php";
include_once "./objects/Task.php";
include_once "./pageElements/projects.php";
include_once "./pageElements/tasks.php";
if (isset($_GET['ID']) && Project::projectExistsId($_GET['ID'])) {
    
    $project = new Project($_GET['ID']);
    if ($_SESSION['account']->getID() != $project->getOwner()) {
        projectNotExist();
        return;
    }
    $_SESSION['project'] = $project->getID();
    
} else {
    projectNotExist();
    return;
}
?>


<div class="projectTitle">
    <span>
        <?php echo $project->getName();?>
    </span>
</div>

<div class="left">

    <div class="projectOverview panelBody">
        <div class="titleBar barHead">
            <div  class="panelTitle">
                <span>
                    <a href="/allTasks.php?ID=<?php echo $project->getID();?>">Tasks</a>
                </span>
            </div>
            <div  class="newTaskButtonBox">
                <button class="genericButton" id="newTaskButton" type="button">+ new Task</button>
            </div>
        </div>
        <div class="fitTasks">
        <?php listTasks(); ?>
        </div>
    </div>
</div>

<div class="right">
    <div class="projectIssues panelBody">
        <div class="titleBar barHead">
            <div  class="panelTitle">
                <span>
                    <a href="/">Issues</a>
                </span>
            </div>
        </div>
        
    </div>

    <div class="projectMembers panelBody">
        <div class="titleBar barHead">
            <div  class="panelTitle">
                <span>
                    <a href="/">Members</a>
                </span>
            </div>
        </div>
    </div>
</div>

<?php createTaskWindow();?>


</div>
</body>
<?php

include_once "pageElements/footer.php";

?>
