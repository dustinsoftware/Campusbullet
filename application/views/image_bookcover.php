<h1>Book Cover Detection</h1>

<? if ($message) echo "<p class=\"info\">$message</p>"; ?>
<img src="<?=$coverlink?>" alt="" /><br />
<p>This is the cover we think belongs to your book.&nbsp; Would you like to use this cover?</p>

<form action="" method="post">
<input type="submit" name="yes" value="Yep, that's right!" /> <input type="submit" name="no" value="No, don't use that image." />
</form>
