<?php
/** 
 * @author Brian Floersch <gh123man@gmail.com>
 */
include_once "./pageElements/headder.php";
?>
<LINK href="/static/css/pageContent.css" rel="stylesheet" type="text/css">
<body>
<div class="pageContent">

<?php
include_once "./pageElements/projects.php";
listMyProjects();
echo "<br>";
createProjectField();
?>



</div>
</body>
<?php

include_once "pageElements/footer.php";

?>
