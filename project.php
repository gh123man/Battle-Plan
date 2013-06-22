<?php

include_once "./pageElements/headder.php";
?>
<LINK href="/static/css/pageContent.css" rel="stylesheet" type="text/css">
<body>
<div class="pageContent">

<?php
include_once "./objects/Project.php";
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

<h2><?php echo $project->getName();?></h2>




</div>
</body>
<?php

include_once "pageElements/footer.php";

?>
