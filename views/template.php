<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>The MasterList<? if ($title) echo " - $title"; ?></title>
<style type="text/css">
.error {
	background: red;
	color: white;
}
.info {
	background: Yellow;
	color: black;
}
</style>
<? foreach ($styles as $file) echo HTML::style($file), "\n"; ?>
<? foreach ($scripts as $file) echo HTML::style($file), "\n"; ?>
</head>

<body>
<div id="header">
<a href="<?= $url_base ?>">
<img src="<?= $url_base ?>images/logo.png" id="sitelogo" alt="The MasterList" style="left: 20px; top: 24px" /></a>

<div id="header_right">
<div id="header_login">
	<? if ($user) { ?>
	You&#39;re logged in as <?=$user?>.&nbsp; <a href="<?= $url_base ?>login/logout">Log out</a>?
	<? } else { ?>
	You're not logged in.  <a href="<?= $url_base ?>login">Login here.</a>
	<? } ?>
</div>
<div id="header_menu">
<ul>
<li><a href="<?= $url_base ?>account/newpost">new post</a></li>
<li><a href="<?= $url_base ?>categories">categories</a></li>
<li><a href="<?= $url_base ?>account">my account</a></li>
<li><a href="<?= $url_base ?>help/faq">faq</a></li>

</ul>
</div>

</div>

</div>
<div id="mainContainer">
<div id="header_shadow"></div>

<!-- sidebar start -->
<? if ($sidebar) { ?>
<div id="sidebar">
	<div id="sidebar_inner">
		<? echo $sidebar; ?>
	</div>
</div>

<? } ?>

<!-- sidebar end -->

<div id="content">

<!--content start -->

<? echo $content; ?>

</div>

<!--content end -->


</div>

</body>

</html>

