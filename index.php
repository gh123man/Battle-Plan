<?php
/* Copyright (C) 2013 WebSystem Development Team - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brian Floersch <gh123man@gmail.com>
 */


session_start();

include_once "./objects/Account.php";

if (!isset($_SESSION['loggedin'])) {
    Account::checkCookie();
}


switch (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {

     case true: // IF LOGGED IN, DRAW REQUESTED PAGE;
         include_once "./pageElements/home.php";
         break;
     
     case false:
        include_once "./pageElements/landing.php";
        break;

}
        
?>

