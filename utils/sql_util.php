<?php
/* Copyright (C) 2013 WebSystem Development Team - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brian Floersch <gh123man@gmail.com>
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

    /*
    $connection = mysql_connect($GLOBALS['defaultAddress'],$GLOBALS['DefaultUsername'],$GLOBALS['DefaultPassword']);
    if (!$connection){
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($GLOBALS['defaultDB'], $connection);
    */
    $GLOBALS['currentConnection'] = $connection;

}

function close() {
    //mysql_close($GLOBALS['currentConnection']);
}

function pref_connect($address, $uname, $pword, $db) {
    $connection = mysql_connect($address,$uname,$pword);
    if (!$connection){
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($GLOBALS['defaultDB'], $connection);

}

?>
