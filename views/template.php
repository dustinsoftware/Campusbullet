<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>MasterList Sample Template</title>
<style type="text/css">
#loginbox {
	position: absolute;
	top: 5px;
	right: 5px;
	
}
.error {
	background: red;
	color: white;
}
.info {
	background: Yellow;
	color: black;
}
</style>
</head>

<body>
<?= $content ?>

<? if ($user) { ?>
<div id="loginbox">
You are logged in as <?= $user ?>.&nbsp; <a href="<?= $url_base ?>login/logout">Log out?</a>
</div>
<? } ?>
</body>

</html>
