<? if ($editmode) $title = "Edit your post!"; else $title = "Post something new!"; ?>
<h1><?=$title?></h1>

<? if ($message) { ?>
	<p class="info"><?=$message?></p>
<? } ?>
<? if ($errors) { ?><ul class="error">
<? foreach ($errors as $error) { ?><li><?=$error?></li><? } ?></ul>
<? } else { ?>
<p>Hey, you want to post something to sell or give away?&nbsp; Awesome!&nbsp; Please remember that there are a few rules:
<ul>
	<li>Nothing illegal</li>
	<li>No reposts more often than once every 7 days</li>
	<li>Make sure you have a quick look over the <a href="<?=$url_base?>help/terms">terms and conditions</a>.&nbsp; Don't worry, it's short :)</li>	
</ul>
</p>
<? if ($disabled == 1) { ?><p class="info">Note: This post is disabled.&nbsp; To repost it, just hit "Preview this Post".</p><? } ?>
<? if ($disabled == 2) { ?><p class="error">This post has been flagged.&nbsp; It cannot be re-enabled.</p><? } ?>
<? } ?>

<form action="" method="POST" >
<table>
<tr>
	<th>Post title:</th>
	<td><input type="textbox" name="title" value="<?=$post_title?>" /></td>
</tr>
<tr>
	<th>Condition of item:</th>
	<td><input type="textbox" name="condition" value="<?=$post_condition?>" /></td>
</tr>
<tr>
	<th>Category:</th>
	<td><select name="category" style="width: 200px" onchange="showhide()">
	<?foreach ($categories as $category) {		
		if ($post_category == $category['id']) {
			echo "<option selected=\"selected\" value=\"$category[id]\">$category[prettyname]</option>\r\n";
		} else {
			echo "<option value=\"$category[id]\">$category[prettyname]</option>\r\n";
		}
			
	} ?>	
	</select>
</tr>
<tr class="hidden" id="books">
	<th>ISBN:</th>
	<td><input type="textbox" name="isbn" value="<?=$post_isbn?>" /></td>
</tr>
<tr>
	<th>Asking price: ($)</th>
	<td><input type="textbox" name="price" value="<?=$post_price?>" /> (0 if the item is free)</td>
</tr>
<tr>
	<th>Describe the item:</th>
	<td><textarea name="description" style="width:500px; height: 200px;"><?=$post_description ?></textarea></td>
</tr>
<tr>
	<th></th>
	<td><? if ( ! ($disabled == 2))  { ?><input type="submit" name="submit" value="Preview the post" /><? } ?>
	<? if ($editmode) { 
		if ( ! $disabled) {			
			?>  <input type="submit" name="disable" value="Disable this post" /> <?
		}
	
	} ?></td>
</tr>

</table>

</form>

<script type="text/javascript">
function showhide() {
	document.getElementById("books").className = "hidden";
	
	if (document.getElementsByName("category")[0].value == 2) {
		document.getElementById("books").className = "";
	}
}

showhide();
</script>