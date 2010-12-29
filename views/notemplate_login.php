<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>The MasterList | Please log in</title>
<style type="text/css">
#loginfields {
	width: 200px;
	margin-right: auto;
	margin-left: auto;
}
#loginfields p {
	margin: 5px;
}

body {
	font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
	background: #1C4053;
	
}
.center {
	text-align: center;
}
	
.error {
	background:#FFCCCC;
	border: 1px red solid;
	padding: 3px;
}
#loginform {
	margin-top:100px;
	width: 500px;
	background:white;
	margin-left:auto;
	margin-right:auto;
	border: thin gray dashed;
	padding: 10px;
	padding-top: 25px;
	padding-bottom: 25px;
}
h1, ul {
	margin:0;
}
a {
	text-decoration: none;
	color: #1C4053;
}
a:hover {
	text-decoration: underline;
}
</style>
</head>

<body onload="document.forms[0].elements[0].focus();">
<div id="loginform" >
<form  action="" method="post">
<h1 class="center">Log in to the MasterList</h1>
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
	</table>
	
	</div>
</form>
</div>
</body>

</html>
