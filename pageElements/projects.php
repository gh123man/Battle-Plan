<?php
/** 
 * @author Brian Floersch <gh123man@gmail.com>
 */
function listMyProjects() {
    
    $query = $GLOBALS['currentConnection']->prepare('SELECT * FROM Projects where owner = ' . $_SESSION['account']->getID());
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC); 
    
    echo "<lu>";
    while ($result = $query->fetch()) {
        echo "<li>";
        echo '<a href="/project.php?ID=' . $result['ID'] . '">' . $result['name'] . '</a>';
        echo "</li>";
    }
    echo "</lu>";
    

}

function createProjectField() {
    
    echo '<script type="text/javascript" src="/static/js/newProject.js"></script>';
    echo "Manage Projects";
    
    echo '<div id="result"></div>';
    echo '<div id="project">';
    
    echo '<input TYPE="button" Value="Create Project" onClick="newProject(this.parentNode)" /> ';
    echo '</div>';

}

function projectNotExist() {
    echo "project does not exist";
    echo '</div></body>';

    include_once "pageElements/footer.php";
}






?>
