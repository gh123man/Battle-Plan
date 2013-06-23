<?php
include_once "./utils/sql_util.php";
include_once "./objects/Account.php";
session_start();
if (!$_SESSION['loggedin']) {
    header('Location: /');
    return;
}
connect();
?>

<html>
<LINK href="/static/css/global.css" rel="stylesheet" type="text/css">
<LINK href="/static/css/topBar.css" rel="stylesheet" type="text/css">
<LINK href="/static/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/jquery/jquery.js"></script>
<script type="text/javascript" src="/static/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="/static/textfill/jquery.textfill.min.js"></script>
<script type="text/javascript" src="/static/js/topBar.js"></script>

<div class="topBar barHead">
<div class="topBarContent">

    
    <div id="home" class="home">
        <span>
            <a href="/">Home</a>
        </span>
    </div>
    
    <div id="account" class="account">
        
        <div id="accountName" class="accountName">
            <span>
                <a href="/">
                    <?php echo $_SESSION['account']->getfname() . " " . $_SESSION['account']->getlname();?>
                </a>
            </span>
        </div>
        
        <div id="accountOptions" class="accountOptions">
            <span>
                <a href="/logout.php">Logout </a>
            </span>
        </div>
        
        
    </div>


</div>
</div>

<?php


?>
