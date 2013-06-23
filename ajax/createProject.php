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
include_once "./objects/Project.php";

if (isset($_POST['name'])  && strlen($_POST['name']) > 0  && isset($_POST['description'])  && strlen($_POST['description']) > 0  && isset($_POST['deadline'])) {

    $status = Project::createProject($_SESSION['account']->getID(), $_POST['name'], $_POST['description'], $_POST['deadline']);

}

echo json_encode(array('result'=>$status));

?>
