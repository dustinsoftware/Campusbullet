<h1>Upload an image to <a href="<?=$post_link?>"><?=$post_name?></a></h1>
<form action="" method="POST" enctype="multipart/form-data">

<? if ($message) { ?><p class="info"><?=$message?></p><? } ?>
<? if ($image) { ?>
<p>Post image:</p>
<p><img src="<?=$image?>" alt="" /><br />
<input type="submit" name="disable" value="Remove from post" /></p>
<? } ?>


<? if ($errors) { ?>
<div class="error"><ul>
	<? foreach ($errors as $error) {
		echo "<li>$error</li>\r\n";		
	} ?></ul></div>
<? } else { ?>
<p>Use this tool to attach a picture to your post.&nbsp; The file must be a JPEG and under 2 MB in size.&nbsp; 
After you've uploaded it, we'll resize it to fit the page.</p>
<? } ?>

<table>
<tr>
	<td>Picture to upload:</td>
	<td><input type="file" name="picture"</td>
	<td><input type="submit" name="submit" value="Upload the picture!" /></td>
</tr>
</table>
<p></p>
</form>

