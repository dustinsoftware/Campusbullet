<h1>Make an announcement</h1>
<? if ($message): ?><p class="info"><?=$message?></p><? endif; ?>
<p>Use the textbox below to make an announcement.&nbsp; The cute little users will be forced to read it when they visit the homepage.</p>
<p>HTML is allowed..(todo: put a WYSIWIG editor in the box below)<br />
<form method="post" action="">
<textarea name="message" style="width:500px; height:200px;"></textarea><br />
<input type="submit" name="action" value="Announce it!" />
</p>
</form>