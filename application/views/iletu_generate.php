<h1>iLETU Code Generator</h1>

<? if ($code): ?>
<h2>Thanks! Your iTunes code is: <?=$code?></h2>
<p>Now that you've generated a code, click the "Redeem" button in the App Store on your iPhone and enter the code.&nbsp;You can find this under the Featured tab near the bottom.&nbsp;
iLETU will begin downloading immediately.&nbsp; Don't share this code, though, it will only work once!&nbsp; A copy of this page has been emailed to you for your convenience.</p>

<? else: ?>
<p>We're sorry, there are no available codes at this time.&nbsp;
You can always buy the app by using the link below.&nbsp;
It's only 99 cents! (that's less than you pay for just about everything
these days, and you'd be supporting a poor college student)</p>
<p>

</p>

<a href="http://itunes.apple.com/us/app/iletu-an-app-for-letourneau/id478653258?ls=1&amp;mt=8"><img alt="" src="<?=URL::base()?>images/appstore-small.png" ></a>

<? endif; ?>