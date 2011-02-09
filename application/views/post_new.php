<script type="text/javascript">
/*function checkprice(source) {
	var searchterm = escape(document.getElementsByName('title')[0].value);
	alert(searchterm);
	if (source == "google") {
		window.open("http://www.google.com/search?hl=en&tbs=shop%3A1&aq=f&q=" + searchterm);
	} else if (source == "ebay") {
	} else if (source == "half") {
		
	}
}*/
</script>

<?	if ($editmode) $title = "Edit Your Post!";
	else $title = "Post Something New!"; ?>
<h1><?=$title?></h1>

<? if ($message) { ?>
	<p class="info"><?=$message?></p>
<? } ?>
<? if ($errors) { ?><ul class="error">
<? foreach ($errors as $error) { ?><li><?=$error?></li><? } ?></ul>
<? } else { 
		echo "<p>A few things to remember when making a post:</p>";
	?>
	<ul>		
		<li>When your post is at least a week old, you will have the option of reposting it to the top.&nbsp; Please don't create duplicate posts.</li>
		<li>Make sure you have a quick look over the <a href="<?=$url_base?>help/terms">terms and conditions</a>.&nbsp; Don't worry, it's short :)</li>	
		<li>Please don't list any contact information in the post below unless necessary.&nbsp; For example, if you need people to get ahold of you fast,
		putting a phone number is fine.&nbsp; Otherwise, just let users email you through the site (to cut back on spam and for security reasons)</li>
	</ul>
	
	<? if ($disabled == 1) { ?><p class="info">Note: This post is disabled.&nbsp; To repost it, just hit "Preview this Post".</p><? } ?>
	<? if ($disabled == 2) { ?><p class="error">This post has been flagged.&nbsp; It cannot be re-enabled.</p><? } ?>
	<? if ($disabled == 3) { ?><p class="info">Note: This post has expired from the site and is no longer visible to other users.&nbsp; To repost, just hit "Preview this Post".</p><? } ?>
<? } ?>

<? if ($editmode) { 
	echo "<p><a href=\"" . $url_base . "image/post/$post_id\">";
	if ($image_attached) echo "Click here to change or remove the attached image.";
	else echo "Click here to attach a picture to this post.";
	echo "</a></p>\r\n";
} else { 
	if ($wanted) echo "<p>You are creating a wanted post. &nbsp; Click <a href=\"$url_base" . "post/new/$post_category_name\">here</a> to create a normal post.</p>";
	else echo "<p>You are creating a normal post. &nbsp; Click <a href=\"$url_base" . "post/new/$post_category_name?wanted\">here</a> to create a wanted post.</p>";
}
?>

<form action="" method="POST" >
<table class="editor">
<tr>
	<th>Post title:</th>
	<td><input type="textbox" name="title" value="<?=$post_title?>" /></td>
</tr>
<? if ( ! $wanted): ?>
<tr>
	<th>Condition of item:</th>
	<td><input type="textbox" name="condition" value="<?=$post_condition?>" /></td>
</tr>
<tr>
	<th>Price:</th>
	<td><input type="textbox" name="price" value="<?=$post_price?>" /> (0 if the item is free)</td>
</tr>
<? endif; ?>
<tr>

	<th>Category:</th>
	<td><select name="category" style="width: 200px" onchange="showhide()">
	<? foreach ($categories as $category) {		
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
	<th></th>
	<td><br /><? if ($wanted) echo "Describe what you're looking for:"; else echo "Describe the item:"; ?></td>
</tr>
<tr>
	<th></th>
	<td><textarea name="description" style="width:500px; height: 200px;"><?=$post_description ?></textarea></td>
</tr>
<tr>
	<th></th>
	<td><? if ( ! ($disabled == 2))  { ?><input type="submit" name="submit" value="Preview the post" /><? } ?>
	<? if ($allow_repost) { ?><input type="submit" name="repost" value="Repost this to the top of the list" /><? } ?>
	<? if ($editmode) { 
		if ( ! $disabled) {			
			?>  <input type="submit" name="disable" value="Disable this post" /> <?
		}
	
	} else {
		echo "<br /><br />You'll have the chance to upload a picture after you create the post.";
	}
		?></td>
</tr>
</table>

</form>
<? if ($editmode): ?><p>...or, if you changed your mind, <a href="<?=$url_base?>home/view/<?=$post_id?>">click here to view the post instead.</a></p><? endif; ?>
<script type="text/javascript">
function showhide() {
	document.getElementById("books").className = "hidden";
	
	if (document.getElementsByName("category")[0].value == 2) {
		document.getElementById("books").className = "";
	}
}

showhide();
</script>