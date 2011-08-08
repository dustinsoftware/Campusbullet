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
	refreshframe();
}

function changeengine(engine) {
	baseurl = searchengine[engine];
	refreshframe();
}

function refreshframe() {
	document.getElementById('searchengineframe').src = baseurl + isbn;
}

window.addEvent('domready', function() {
	<? foreach ($enginelist as $id => $engine) {
		echo "baseurl = \"$engine[base]\";";
		break;
	} ?>
	<? foreach ($booklist as $isbn => $book) {
		echo "isbn = $isbn;";
		break;
	} ?>
	refreshframe();
});
</script>

<p>Your textbooks for the current semester are shown below.&nbsp; Select a 
textbook, and its search results will appear in the browser below.&nbsp; Select 
the tabs on top to change the search engine.</p>
	<ul>
	<? foreach ($booklist as $isbn => $book): ?>
		<li id="book-<?=$isbn?>"><a href="javascript:void(0);" onclick="changebook(<?=$isbn?>)"><?=$book["title"]?></a></li>
	<? endforeach; ?>
	</ul>
	
	<ul>
	<? foreach ($enginelist as $id => $engine): ?>
		<li id="<?=$id ?>"><a href="javascript:void(0);" onclick="changeengine('<?=$id?>')"><?=$engine["title"]?></a></li>
	<? endforeach; ?>
	</ul>

	<div style="background:white">
	<iframe style="width:100%; height: 800px" id="searchengineframe" src="about:blank"></iframe>
	</div>
<? else: ?>
<p>Save money on your college textbooks by buying them from alternate sources!&nbsp; 
This tool examines the textbooks required by your classes and searches popular 
used textbook websites, including our own.&nbsp; No personal information is 
stored by this tool.&nbsp; To use the tool, follow the five easy steps 
below:</p>
<ol>
	<li>Click and drag this link to your links toolbar.&nbsp; Your links toolbar 
	usually appears right below your address bar at the top of your browser 
	window.<br />
	<br />
	<span style="font-size: large"><strong><a href="javascript:(function(){var%20myDoc%20=%20document;var%20fileref=myDoc.createElement('script');fileref.setAttribute('type','text/javascript');fileref.setAttribute('src',%20'<?=URL::base(false,true)?>scripts/bookstorefix.js');myDoc.getElementsByTagName('head')[0].appendChild(fileref);})();" onclick="return false">
	Textbook Powersearch!</a></strong></span><br />
	<br />
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