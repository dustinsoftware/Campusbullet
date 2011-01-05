<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>The Campus Bullet<? if ($title) echo " | $title"; ?></title>
<? foreach ($styles as $file) echo HTML::style("styles/$file.css"), "\n"; ?>
<? foreach ($scripts as $file) echo HTML::style($file), "\n"; ?>
</head>

<body>
<div id="header">
<a href="<?= $url_base ?>">
<img src="<?= $url_base ?>images/logo.png" id="sitelogo" alt="The Campus Bullet" style="left: 20px; top: 24px" /></a>

<div id="header_right">
<div id="header_login">
	<? if ($user) { ?>		
	You&#39;re logged in as <?=$user?>.&nbsp; <a href="<?= $url_base ?>login/logout">Log out</a><? if ($moderator) echo " or <a href=\"" . $url_base . "moderator\">moderate</a>"; ?>?
	<? } else { ?>
	You're not logged in.  <a href="<?= $url_base ?>login">Login</a> or <a href="<?=$url_base?>register">register!</a>
	<? } ?>
</div>
<div id="header_menu">
<ul>
<li><a href="<?= $url_base ?>contact/message/ml_bug_report">report a bug!</li>
<li><a href="<?= $url_base ?>post/edit">manage posts</a></li>
<li><a href="<?= $url_base ?>account">account</a></li>
<li><a href="<?= $url_base ?>search">search</a></li>
<li><a href="<?= $url_base ?>help">help</a></li>

</ul>
</div>

</div>

</div>
<div id="mainContainer">
<div id="header_shadow"></div>


<div id="content">

<!--content start -->

<? echo $content; ?>

</div>

<!--content end -->


</div>


</body>

</html>

