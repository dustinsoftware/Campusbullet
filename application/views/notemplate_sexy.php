<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>super awesome sexy start page</title>
<style type="text/css">
body {
	background: #244369;
	color: white;	
	font-family:Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
}
a {
	color:white;
	text-decoration:none;
}
a:hover {
	text-decoration:underline;
}
.hidden {
	display:none;
}
#announcements {
	width: 90%;
	margin-left:auto;
	margin-right:auto;
}
.announcement {
	background: white;
	color: black;
	border: 1px solid black;
	padding: 5px;
}
.announcement p {
	margin-top: 0px;
}
.announcement a {
	color:darkblue;
}
</style>
<script type="text/javascript">
function showhide(id) {
	var item = document.getElementById(id);
	if (item.className == "hidden announcement")
		item.className = "announcement";
	else
		item.className = "hidden announcement";
}
</script>
</head>

<body onload="document.forms[0].elements[0].focus();">
<div style="text-align:center;margin-top:50px;">

<h1>Sexy Start Page</h1>
<p><a target="_blank" href="http://mail.letu.edu">email</a> | <a  target="_blank" href="http://courses.letu.edu">blackboard</a> | 
<a  target="_blank" href="http://facebook.com">facebook</a> | <a  target="_blank" href="http://campusbullet.net">campusbullet</a></p>
<form action="http://www.google.com/search" method="get">
The great google: <input type="text" name="q" />&nbsp;<input type="submit" value="  do it  "/>
</form>
</div>
<div id="announcements">
<p>Announcements and crap</p>
<ul>
<? foreach ($announcements as $announcement) {
	echo "<li><a href=\"javascript:showhide($announcement[id])\">$announcement[title]</a><div class=\"hidden announcement\" id=\"$announcement[id]\">$announcement[description]</div></li>";
} ?>
</ul>
</div>
</body>

</html>
