<?php
/* Copyright (C) 2013 WebSystem Development Team - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brian Floersch <gh123man@gmail.com>
 */
 
chdir('..');
include_once "./objects/Account.php";

if (isset($_GET['login']) && $_GET['login']) {

    if ($_POST['username'] == "" || $_POST['password'] == "") {
        echo "0";
    } else {
        
        $account = Account::login($_POST['username'], $_POST['password'], $_POST['autoLogin']);
        if($account->getStatus() == 'badpass') {
            echo "3";
        } else if($account->getStatus() == 'true') {
            echo 1;
        } else {
            echo "2";
        }
    }
    
    
    
} else if (isset($_GET['register']) && $_GET['register']) {
    
    if ($_POST['username'] == "" || $_POST['password'] == "" || $_POST['lname'] == "" || $_POST['fname'] == "") {
        echo "you must fill out all fields";
    } else if ($_POST['password1'] != $_POST['password']) {
        echo "passwords must match";
    } else {
        $account = Account::fromEmail($_POST['username']);
        if($account->exists()) {
            echo "account already exists";
        } else {
            $account = Account::register($_POST['username'], $_POST['password'], $_POST['fname'], $_POST['lname'], $_POST['regautoLogin']);
            if ($account->getStatus() == "true") {
                echo 1;
            }
        }
    }
}



?>
