<h1>Ask Kyle!</h1>
<? if ($errors) { ?>
	<ul class="error">
	<? foreach ($errors as $error)
		echo "<li>$error</li>"; ?>
	</ul>
<? } ?>
<p>In honor of our 100th day online,
we've hired Kyle to be your personal consultant for the junk you want to sell.&nbsp; Some say Kyle is the foremost authority on useless junk and
just about anything, kinda like your local garbage collector, or that hobo on the street corner.</p>

<img src="<?= URL::base()?>images/kyle.jpg" alt="This is kyle" />

<p>Want to get Kyle's opinion on something?&nbsp; Type in a message describing what you're trying to get rid of and what you think it's worth! &nbsp; 
If he approves, you'll get a detailed analytical report.&nbsp; If he doesn't approve...well, let's just hope he approves and leave it at that.</p>

<form action="" method="post" enctype="multipart/form-data"> 
Describe it:<br />
<textarea name="description" style="width: 400px; height: 100px;" ></textarea><br />
<table>
<tr>
	<td>I think it's worth:</td><td><input type="text" name="worth" /></td>
</tr>
<tr>
	<td>Here's a picture:</td><td><input id="pictureuploader" type="file" name="picture" /></td>
</tr>
</table>
<input type="submit" name="submit" value="Ask Kyle!" />
</form>