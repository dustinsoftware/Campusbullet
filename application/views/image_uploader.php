<script type="text/javascript">
function submitpicture() {
	document.getElementById("uploadwait").className = "";
	document.getElementById("pictureuploader").className = "hidden";
	document.formuploader.submit();
}
function remove(id) {
	var confirmed = confirm("Are you sure you want to remove that picture?  This cannot be undone.");
	
	if (confirmed) {
		/*var request = new Request({
			url: '<?=URL::base()?>image/remove/<?=$post_id?>?image=' + id,
			method: 'post',			
			data: 'confirmed=true',
			onSuccess: function(response) {
				
			}
		}).send();*/
		
		 var form = new Element('form',
			{method: 'post', action: '<?=URL::base()?>image/remove/<?=$post_id?>?image=' + id});
		 form.adopt(new Element('input',
			 {name: 'confirmed', value: 'true', type: 'hidden'}));
		 $(document.body).adopt(form);
		 form.submit();

	}
	
	return false;
}
</script>

<h1>Image Uploader - <a href="<?=$post_link?>"><?=$post_name?></a></h1>
<? if ($newpost && count($post_images) == 0): ?><p>You can upload a picture if you want.&nbsp; Or, if you'd rather not, you can <a href="<?=$url_base?>home/view/<?=$post_id?>?newpost">skip this step.</a></p><? endif; ?>
<? if ($message) { ?><p class="info"><?=$message?></p><? } ?>

<? if ($post_images) { ?>
<h2>Currently uploaded pictures:</h2>
	<div id="images">
	
	<? foreach ($post_images as $image) { ?>
		<div id="image-<?=$image['index']?>" class="imagebox">
		<img src="<?=$image['link']?>" width="<?=$image['width']?>" height="<?=$image['height']?>" alt=""/><br />
		<a onclick="return remove(<?=$image['index']?>);" href="<?=$url_base?>image/remove/<?=$post_id?>?image=<?=$image['index']?>">(delete image)</a>
		</div>
	<? } ?>
	</div>
<? } ?>

<? if ($allow_image_upload): ?>
<form action="" name="formuploader" method="POST" enctype="multipart/form-data">
<h2>Upload a picture:</h2>
<? if ($errors) { ?>
<ul class="error">
	<? foreach ($errors as $error) {
		echo "<li>$error</li>\r\n";		
	} ?></ul>
<? } else { ?>
<p>Upload a picture below.
After you've uploaded it, we'll resize it to fit the page.&nbsp; You can have up to <?=$image_limit?> pictures on a post.</p>
<? } ?>
	
<input id="pictureuploader" type="file" name="picture" onchange="submitpicture()" />
<div id="uploadwait" class="hidden">Uploading...</div>

<p>You could also <a target="_blank" href="http://images.google.com/images?q=<?= urlencode($post_name) ?>">google around for an image</a>...</p>


</form>

<? endif ; ?>

<p>What next?</p><ul>
<li><a href="<?=$url_base?>home/view/<?=$post_id?>">View your post</a></li>
<li><a href="<?=$url_base?>post/edit/<?=$post_id?>">Edit your post</a></li>
</ul>