<?php
/** 
 * @author Brian Floersch <gh123man@gmail.com>
 */
chdir("..");
include_once "./objects/Account.php";
session_start();
if (!$_SESSION['loggedin']) {
    return;
}
include_once "./objects/Task.php";

if (isset($_POST['name']) && strlen($_POST['name']) > 0 && isset($_POST['description']) && strlen($_POST['description']) > 0  && isset($_POST['deadline'])) {
    if (!isset($_POST['parent'])) {
        $_POST['parent'] = null;
    }
    $stamp = strtotime($_POST['deadline']);
    $status = Task::createTask($_SESSION['account']->getID(), $_POST['parent'], $_SESSION['project'], $_POST['name'], $_POST['description'], null, $stamp);

} else {
    $status = false;
}

echo json_encode(array('result'=>$status));

?>
