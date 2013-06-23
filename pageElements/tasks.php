<?php

function listTasks() {
    $query = $GLOBALS['currentConnection']->prepare('SELECT * FROM Tasks where owner = "' . $_SESSION['account']->getID() . '" and project = "' . $_SESSION['project'] . '" and parent is null order by time asc');
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC); 
    
    while ($result = $query->fetch()) {
        echo "<li>";
        echo '<a href="/task.php?ID=' . $result['ID'] . '">' . $result['name'] . '</a>';
        echo "</li>";
    }
}

function listSubTaskNodes($parent, $project) {
    if ($parent == null) {
        $query = $GLOBALS['currentConnection']->prepare('SELECT ID FROM Tasks where owner = "' . $_SESSION['account']->getID() . '" and project = "' . $project . '" and parent is null order by time asc');
    } else {    
        $query = $GLOBALS['currentConnection']->prepare('SELECT ID FROM Tasks where owner = "' . $_SESSION['account']->getID() . '" and project = "' . $project . '" and parent = "' . $parent . '" order by time asc');
    }
    
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC); 
    
    while ($result = $query->fetch()) {
        showSubTaskNode($result['ID']);
    }
}

function drawNavigaiton($ID) {
    $query = $GLOBALS['currentConnection']->prepare('SELECT * FROM Tasks where owner = "' . $_SESSION['account']->getID() . '" and ID = "' . $ID . '" order by time asc');
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC); 
    $result = $query->fetch();
    
    if (isset($result['parent'])) {
        drawNavigaiton($result['parent']);
    }
    echo " > ";
    echo '<a href="/task.php?ID=' . $result['ID'] .'">';
    echo '<span class="navItem">';
    echo $result['name'];
    echo "<span>";
    echo '</a>';
    
    
}

function createTaskWindow() {
    ?>
    <LINK href="/static/css/project.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/static/js/newTaskWindow.js"></script>
    <div style="display:none;" id="newTaskWindow">
    
    <form method="post" name="newTask" id="newTask">
    Name: <input type="text" name="tName" id="tName">
    Description: <input type="text" name="description" id="description">
    Deadline: <input type="text" name="deadline" id="deadline">
    <input TYPE="button" Value="Create" onClick="requestTask(this.parentNode)" />
    </form>
    <div id="TaskResult">
    </div>
    
    </div>
   <?

}

function taskNotExist() {
    echo "task does not exist";
    echo '</div></body>';

    include_once "pageElements/footer.php";
}


function showTaskNode($task) {
    ?>
    <div class="taskPanel">
        <div class="panelBody">
            <div class="titleBar barHead">
                <div  class="panelTitle">
                    <span>
                        <a href="/task.php?ID=<?php echo $task->getID() ?>"><?php echo $task->getName(); ?></a>
                    </span>
                </div>
                
                <div class="newTaskButtonBox">
                    <button class="genericButton" id="newTaskButton" type="button">+ new Task</button>
                </div>
                
            </div>
            
            <div class="description">
                <span>
                    <?php echo $task->getDescription(); ?>
                </span>
            </div>
            
            <div class="subTitle">
                Sub-Tasks:
            </div>
            
            <div class="subTasks">
                <?php
                listSubTaskNodes($task->getID(), $task->getProject());
                ?>
            </div>
            
        </div>
    </div>

    <?

}

function showSubTaskNode($ID) {
    $task = new Task($ID);
    ?>
    
    <div class="subTaskPanel">
        <div class="panelBody nodeShadow">
            <div class="titleBar barHead">
                <div  class="panelTitle">
                    <span>
                        <a href="/task?ID=<?php echo $task->getID() ?>"><?php echo $task->getName(); ?></a>
                    </span>
                </div>
                
            </div>
            
            <div class="description">
                <span>
                    <?php echo $task->getDescription(); ?>
                </span>
            </div>
            
        </div>
    </div>
    
    <?
}






?>
