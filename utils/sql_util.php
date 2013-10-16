<?php
/** 
 * @author Brian Floersch <gh123man@gmail.com>
 */
 

include_once './config/default.php';

function connect() {
    //if we are already connected, dont re-connect
    if (isset($connection)) {
        return;
    }
    $connection = new PDO('mysql:dbname=' . $GLOBALS['defaultDB'] . ';host=' . $GLOBALS['defaultAddress'] . ';charset=utf8', $GLOBALS['DefaultUsername'], $GLOBALS['DefaultPassword']);
    $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $GLOBALS['currentConnection'] = $connection;

}

?>
