<style type="text/css">
.bold {
	font-weight: bold;
}
</style>
<h1><?=$post_title ?></h1>
<table>
<tr><td>Posted in:</td><td><a href="<?=$url_base?>home/category/<?=$post_category_name?>"><?=$post_category_name?></a></td></tr>
<tr><td>Price:</td><td><?=$post_price?></td></tr>
<tr><td>Condition:</td><td><?=$post_condition?></td></tr>
<? if ($post_isbn) {
	if (strlen($post_isbn) == 13) {
		$post_isbn = substr($post_isbn,0,3) . "-" . substr($post_isbn,3,1) . "-" . substr($post_isbn,4,5) . "-" . substr($post_isbn,9,3) . "-" . substr($post_isbn,12,1);
	}
	echo "<tr><td>ISBN:</td><td>$post_isbn</td></tr>\r\n";
} ?>
</table>

<p><span class="bold">Description of item:</span><br />
<pre><?=$post_description ?></pre>
</p>

<? if ($post_image) { ?> <p><img src="<?=$post_image?>" alt="" /></p><? } ?>

<? if ( ! $preview) { ?>
<? if ($is_owner) { ?>
<p>You are the owner of this post.</p>
<ul>
	<li><a href="<?= $url_base ?>post/edit/<?=$post_id?>">Edit or disable this post</a></li>
	<li><a href="<?= $url_base ?>image/post/<?=$post_id?>">Attach or remove a picture to this post</a></li>	
</ul>
<? } else { ?>
<p>What next? </br>
<ul>
	<li><a href="<?= $url_base ?>contact/want/<?=$post_id?>">I want this item!</a></li>
	<li><a href="<?= $url_base ?>contact/message/ml_abuse?postid=<?=$post_id?>">Report this item..</a></li>	
</ul>
</p>
<? } ?>
<? } ?>