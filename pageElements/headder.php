<?php
session_start();
if (!$_SESSION['loggedin']) {
    header('Location: /');
    return;
}

?>

<html>
<LINK href="/static/css/global.css" rel="stylesheet" type="text/css">
<LINK href="/static/css/topBar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/jquery/jquery.js"></script>
<script type="text/javascript" src="/static/jquery-ui/jquery-ui.js"></script>

<div class="topBar"></div>

<?php


?>
