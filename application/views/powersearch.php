<style type="text/css">
.bookselected a {
	color: white;
}
.instructions li {
	margin: 10px;
}
.tabs {
	padding: 0px;
	margin: 7px;
}
.tabs li {
	display: inline;
	margin: 0;
}
.tabs li a {
	padding: 7px;
	color: gray;
	background: black;
	text-decoration: none;
}

.tabs li a:hover, .tabs li a.tabselected {
	color: white;
}

</style>
<script type="text/javascript">
function hidenotice() {
	document.getElementById('notice').style.display = "none";
}
</script>

<h1>Textbook Powersearch!</h1>

<? if ($booklist): ?>
<script type="text/javascript">
var baseurl = "";
var isbn = "";
var searchengine = new Object();

<? foreach ($enginelist as $id => $engine): ?>
	searchengine['<?=$id?>'] = "<?=$engine['base']?>";
<? endforeach; ?>

function changebook(sourceisbn) {
	isbn = sourceisbn;
	<? foreach($booklist as $isbn => $book): ?>
                document.getElementById('book-<?=$isbn?>').className = "";
        <? endforeach; ?>
	document.getElementById('book-' + sourceisbn).className = "bookselected";
	refreshframe();
}

function changeengine(engine) {
	baseurl = searchengine[engine];
	<? foreach ($enginelist as $id => $engine): ?>
		document.getElementById('<?=$id?>').className = "";
	<? endforeach; ?>
	document.getElementById(engine).className = "tabselected";
	refreshframe();
}

function refreshframe() {
	document.getElementById('searchengineframe').src = baseurl + isbn;
}

window.addEvent('domready', function() {
	<? foreach ($enginelist as $id => $engine) {
		echo "changeengine('$id');";
		break;
	} ?>
	
	<? foreach ($booklist as $isbn => $book) {
		echo "changebook('$isbn');";
		break;
	} ?>
		
});
</script>

<p>Your textbooks for the current semester are shown below.&nbsp; Select a 
textbook, and its search results will appear in the browser below.&nbsp; Select 
the tabs on top to change the search engine.</p>
	<ul class="textbooks">
	<? foreach ($booklist as $isbn => $book): ?>
			<li id="book-<?=$isbn?>"><a href="javascript:void(0);" onclick="changebook('<?=$isbn?>')"><?=$book["title"]?></a>
			<? if ($book['matches']): ?>
				- <a style="color: yellow" href="<?=URL::base()?>search?q=<?=$isbn?>"><? if($book['matches'] == 1) echo "1 copy is for sale on The Campus Bullet!"; if ($book['matches'] > 1) echo "$book[matches] copies are for sale on The Campus Bullet!";?></a>
			<? endif; ?>
	<? endforeach; ?>
	</ul>
	
	<ul class="tabs">
	<? foreach ($enginelist as $id => $engine): ?>
		<li><a id="<?=$id ?>" href="javascript:void(0);" onclick="changeengine('<?=$id?>')"><?=$engine["title"]?></a></li>
	<? endforeach; ?>
	</ul>

	<div style="background:white">
	<iframe style="width:100%; height: 800px" id="searchengineframe" src="about:blank"></iframe>
	</div>
<? else: ?>
<p>Save money on your college textbooks by buying them from alternate sources!&nbsp; 
This tool examines the textbooks required by your classes and searches popular 
used textbook websites, including our own.&nbsp; No personal information is 
stored by this tool.&nbsp; To use it, follow the five easy steps 
below:</p>
<ol class="instructions">
	<li>Click and drag this link to your bookmarks toolbar.&nbsp; Your bookmarks toolbar 
	usually appears right below your address bar at the top of your browser 
	window.<br />
	<br />
	<span style="font-size: large"><strong><a href="javascript:(function(){var%20myDoc%20=%20document;var%20fileref=myDoc.createElement('script');fileref.setAttribute('type','text/javascript');fileref.setAttribute('src',%20'<?=URL::base(false,true)?>scripts/bookstorefix.js');myDoc.getElementsByTagName('head')[0].appendChild(fileref);})();" onclick="return false">
	Textbook Powersearch!</a></strong></span><br />
	<br />
	Help for: <a href="http://www.google.com/support/chrome/bin/answer.py?answer=95745" target="_blank">Chrome</a> | 
	<a href="http://support.mozilla.com/en-US/kb/Bookmarks%20Toolbar" target="_blank">Firefox</a> | 
	<a href="http://windows.microsoft.com/en-US/windows-vista/Show-or-hide-the-Favorites-bar-in-Internet-Explorer-8" target="_blank">Internet Explorer</a>
	<? if (eregi("chrome", $_SERVER['HTTP_USER_AGENT'])): ?>
	<p class="info" id="notice"><strong>Chrome users:</strong> Chrome has a bug in it that might cause no text show up when you drag the icon to your
	bookmarks bar.&nbsp; To fix this, right-click the globe icon after you drag the link, click Edit, and give the bookmarklet a name.
	<input type="button" value="OK, Thanks." onclick="javascript:hidenotice()"></p>
	<? endif; ?>
	</li>
	<li>Click on the "Textbook Powersearch!" button in your toolbar.</li>
	<li>Log in with your LETU username and password.&nbsp; This information is 
	sent to LeTourneau's servers.&nbsp; <strong>Your LETU username and password 
	are never transmitted to us</strong>.</li>
	<li>Click on the "Purchase from efollett.com" link on the page.</li>
	<li>Click on the "Textbook Powersearch!" button again on your toolbar.&nbsp; 
	This time, you will be taken to the powersearch page with all of your 
	textbooks displayed, along with several different textbook search engines!</li>
</ol>

<? endif; ?>
