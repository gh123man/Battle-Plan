<?php
/** 
 * @author Brian Floersch <gh123man@gmail.com>
 */
?>

<script type="text/javascript" src="/static/jquery/jquery.js"></script>

<h1>Already Here? Sign in!</h1>
<script type="text/javascript" src="/static/js/checkCreds.js"></script>

<form method="post" name="login" id="login">
Username: <input type="text" id="username" onkeypress="handleKey(event,this)" />
Password: <input type="password" id="password" 
onkeypress="handleKey(event,this)"/>
<input type="checkbox" id="autoLogin" name="autoLogin"/>Stay Logged In
<input TYPE="button" Value="Sign In &gt;" onClick="checkCreds()"/>
</form>

<div id="credsOut"></div>
<h1>Want In? Make an account!</h1>
<form method="post" name="register" id="register">
First Name: <input type="text" name="fname" id="fname" />
Last Name: <input type="text" name="lname" id="lname" /><br />
Email: <input type="text" name="newusername" id="newusername" /><br />
Password: <input type="password" name="newpassword" id="newpassword" />
Re-enter Password: <input type="password" name="renewpassword" 
id="renewpassword" />
<input type="checkbox" name="regAutoLogin" id="autoLoginReg"/>Stay Logged In
<input TYPE="button" NAME="register" Value="Register &gt;" onClick="checkRegister()"/>
</form>
<div id="regOut"></div>
