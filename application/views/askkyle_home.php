<script type="text/javascript">

</script>

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

<div style="text-align: center">
<img src="<?= URL::base()?>images/kyle-2.jpg" alt="This is kyle" />&nbsp;&nbsp;
<img src="<?= URL::base()?>images/kyle-1.jpg" alt="This is kyle" />&nbsp;&nbsp;
<img src="<?= URL::base()?>images/kyle-3.jpg" alt="This is kyle" />&nbsp;&nbsp;
</div>

<p>Want to get Kyle's opinion on something?&nbsp; Type in anything, and the all knowledgable Kyle will (probably not) write you back with an all-wise response!&nbsp;
Results may vary.</p>


<form action="" method="post" enctype="multipart/form-data"> 
Dear Kyle,<br />
<textarea name="message" style="width: 700px; height: 300px;" ><?=$message?></textarea><br />
<table>
<tr>
	<td>I'd like him to write me back at this email address:</td><td><input type="text" name="email" style="width: 300px" value="<?=$email?>"/></td>
</tr>
</table>
<input type="submit" name="submit" value="Ask Kyle!" />
</form>