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
include_once "./pageElements/projects.php";

if (isset($_GET['ID']) && Project::projectExistsId($_GET['ID'])) {

    $project = new Project($_GET['ID']);
    
    if ($_SESSION['account']->getID() != $project->getOwner()) {
        projectNotExist();
        return;
    }
    
} else {
    projectNotExist();
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

All Tasks
<?php

listSubTaskNodes(null, $project->getID());

?>


</div>
</body>
<?php

include_once "pageElements/footer.php";

?>
