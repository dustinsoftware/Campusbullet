<h1>Upload an image to <a href="<?=$post_link?>"><?=$post_name?></a></h1>
<form action="" method="POST" enctype="multipart/form-data">

<? if ($message) { ?><p class="info"><?=$message?></p><? } ?>
<? if ($image) { ?>
<p>Post image:</p>
<p><img src="<?=$image?>" alt="" /><br />
<input type="submit" name="disable" value="Remove from post" /></p>
<? } ?>


<? if ($errors) { ?>
<ul class="error">
	<? foreach ($errors as $error) {
		echo "<li>$error</li>\r\n";		
	} ?></ul>
<? } else { ?>
<p>Use this tool to attach a picture to your post.&nbsp; The file must be a PNG, JPEG, or GIF type file and under 2 MB in size.&nbsp; 
After you've uploaded it, we'll resize it to fit the page.</p>
<? } ?>

<table>
<tr>
	<td>Picture to upload:</td>
	<td><input type="file" name="picture"</td>
	<td><input type="submit" name="submit" value="Upload the picture!" /></td>
</tr>
</table>
<p>You could also <a target="_blank" href="http://images.google.com/images?q=<?= urlencode($post_name) ?>">google around for an image</a>...</p>

<p>What next?</p><ul>
<li><a href="<?=$url_base?>home/view/<?=$post_id?>">View your post</a></li>
<li><a href="<?=$url_base?>post/edit/<?=$post_id?>">Edit your post</a></li>
</ul>
</form>

