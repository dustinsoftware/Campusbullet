<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>The Campus Bullet | Please log in</title>
<link type="text/css" href="<?=$url_base?>styles/login.css" rel="stylesheet" />

</head>

<body onload="document.forms[0].elements[0].focus();">
<div id="loginform" >
<form  action="" method="post">
<h1 class="center">Log in to The Campus Bullet</h1>
	<? if ($error) { ?>
	<p class="center error"><?=$error?></p>
	<? } else { ?>
	<p class="center">Please log in using the form below.<br />Or, <a href="<?=$url_base?>register">register for an account</a> if you 
	don&#39;t have one.</p>	
	<? } ?>
	<div id="loginfields" style="width: 286px">
	<table>
	<tr><td>Username:</td><td><input name="user" type="text" style="width: 163px" /></td></tr>
	<tr><td>Password:</td><td><input name="asdf" type="password" style="width: 163px"/></td></tr>
	<tr><td></td><td><input name="action" id="sumbit_button" type="submit" value="login" style="width: 84px" /></td></tr>
	<tr><td colspan="2" style="text-align: center"><br /><a href="<?=$url_base?>register/forgotpassword">Forgot your username or password?</a></td></tr>
	</table>
	
	</div>
</form>
</div>
</body>

</html>
