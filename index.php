<?php
/** 
 * @author Brian Floersch <gh123man@gmail.com>
 */


session_start();

include_once "./objects/Account.php";

if (!isset($_SESSION['loggedin'])) {
    Account::checkCookie();
}

switch (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {

     case true: // IF LOGGED IN, DRAW REQUESTED PAGE;
         header('Location: /home.php');
         break;
     
     case false:
        include_once "./pageElements/landing.php";
        break;

}
        
?>

