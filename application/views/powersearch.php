<h1>Textbook Powersearch!</h1>

<? if ($booklist): ?>
	<?= Kohana::debug($booklist) ?>
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