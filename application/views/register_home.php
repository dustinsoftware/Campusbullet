<form action="" method="post">
<h1 class="center">Register for The Campus Bullet</h1>
<p>Hey, awesome!&nbsp; We&#39;re glad you want to post stuff on The Campus Bullet.&nbsp; 
Before you sign up, there are a few things you should know:</p>
<p><span style="font-weight: bold">What is The Campus Bullet?</span>&nbsp; The Campus Bullet is a craigslist-style bulletin board system
for posting up stuff you want to sell to other students, like textbooks for example.&nbsp; It's totally free and pretty simple to use.</p>

<p><span style="font-weight: bold">How does it work?</span>&nbsp; Post an item up by entering a few short details.&nbsp; After posting the item and
 someone sees it, they'll send you an email through the site regarding the item.&nbsp; You'll respond to the email through your inbox.&nbsp; After
 you've sold the item, just take it down and you'll stop receiving emails regarding it.&nbsp; Pretty simple, right? </p>
<p>Also, you should know that use of the service is <strong>at your own risk</strong> 
and you actually have to meet whoever you&#39;re selling stuff to in person, which 
will take social skills.&nbsp; You have been warned.</p>
<p>To begin, enter your @letu.edu address below.&nbsp; We&#39;ll send you a quick 
email so you can verify you own that email account.</p>

<? if ($errors) { ?><ul class="error"><? foreach ($errors as $error) echo "<li>$error</li>\r\n"; ?></ul><? } ?>
<p class="center">Your LETU Email Address: <input name="email" type="text" style="width: 285px" />&nbsp;<input name="submit" type="submit" value="Submit, foo!" /></p>
	
</form>
