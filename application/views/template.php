<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="the campus bullet" name="keywords" />
<meta content="A fancy site for LETU students to sell their junk on." name="description" />
<? if (isset($feed)): ?><link rel="alternate" type="application/rss+xml" title="<?=$feed['title']?>" href="<?=$feed['link']?>" /> <? endif; ?>
<? if (isset($fb_title)): ?><!--facebook post information -->
	<meta http-equiv="CACHE-CONTROL" content="NO-CACHE" />
	<? if ($post_wanted): ?><meta property="og:title" content="I'm looking for a <?=$fb_title?>!" />
	<? else: ?><meta property="og:title" content="I'm selling my <?=$fb_title?>!" />
	<? endif; ?>
	<meta property="og:description" content="<?=$fb_description?>" />
	<? if ($fb_image): ?><meta property="og:image" content="<?=$fb_image?>" />
	<? else: ?><meta property="og:image" content="<?=$url_base?>images/stuff.png" />
	<? endif; ?>
<? endif; ?>

<link type="image/x-icon" href="<?=$url_base?>images/favicon.gif" rel="shortcut icon" />
<title>The Campus Bullet<? if ($title) echo " | $title"; ?></title>

<? foreach ($styles as $file) echo HTML::style("styles/$file.css"), "\n"; ?>
<? foreach ($scripts as $file) echo "<script type=\"text/javascript\" src=\"{$url_base}scripts/$file.js\" />"; ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20605781-1']);
  _gaq.push(['_setDomainName', '.campusbullet.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript">
function go(page) {
	location.href = "<?=$url_base?>" + page;
}
function searchBoxFocus() {
	var sb = $('searchboxinput');
	
	if (sb.value == "Search...") {
		sb.value = "";
	}
	
}
function searchBoxBlur() {
	var sb = $('searchboxinput');
	
	if (sb.value == "") {
		sb.value = "Search...";
	}
}

</script>
<meta property="fb:admins" content="703125477"/>
</head>

<body>
<div id="header">

	
	<div id="header_logo">
		<a href="<?= $url_base ?>">
		<img src="<?= $url_base ?>images/logo.png" id="sitelogo" alt="The Campus Bullet" /></a>
	</div>
	
	<div id="header_right">
		<div id="header_login">
			<? if ($user) { ?>		
			You&#39;re logged in as <?=$user?>.&nbsp; <a href="<?= $url_base ?>login/logout">Log out</a><? if ($moderator) echo " or <a href=\"" . $url_base . "admin\">admin</a>"; ?>?
			<? } else { ?>
			You're not logged in.  <a href="<?= $url_base ?>login">Login</a> or <a href="<?=$url_base?>register">register!</a>
			<? } ?>
		</div>
		<div id="header_menu">
			<ul>
			<li><a href="<?= $url_base ?>">home</a></li>
			<li><a href="<?= $url_base ?>post/edit">posts</a></li>
			<li><a href="<?= $url_base ?>account">account</a></li>
			<li><a href="<?= $url_base ?>help">help</a></li>

			</ul>
		</div>

	</div>
	

</div>
<div id="mainContainer">
<div id="header_shadow"></div>
<div id="searchbox"><form action="<?= $url_base ?>search" method="get"><input id="searchboxinput" type="text" class="initial" name="q" onfocus="searchBoxFocus()" onblur="searchBoxBlur()" value="<? if ($searchquery) echo $searchquery; else echo "Search..."; ?>" /></form></div>

<div id="content">

<!--content start -->
<? echo $content; ?>

</div>

<!--content end -->


</div>


</body>

</html>

