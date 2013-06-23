<?php
/* Copyright (C) 2013 WebSystem Development Team - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brian Floersch <gh123man@gmail.com>
 */
chdir("..");
include_once "./objects/Account.php";
session_start();
if (!$_SESSION['loggedin']) {
    return;
}
connect();
include_once "./objects/Task.php";

if (isset($_POST['close']) && isset($_POST['ID']) &&  $_POST['close'] == "true") {
    
    $task = new Task($_POST['ID']);
    
    if ($task->getOwner() == $_SESSION['account']->getID()) { //change this for members later
        $task->setFinished(1);
        $status = true;
    }
} else if (isset($_POST['open']) && isset($_POST['ID']) &&  $_POST['open'] == "true") {
    
    $task = new Task($_POST['ID']);
    
    if ($task->getOwner() == $_SESSION['account']->getID()) { //change this for members later
        $task->setFinished(0);
        $status = true;
    }
} else {
    $status = false;
}

echo json_encode(array('result'=>$status));

?>
