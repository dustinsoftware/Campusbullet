<div id="newposts">
<h1>Newest Posts!</h1>
<ul>
<? foreach ($newposts as $post) { 
	if (strlen($post['name']) > 50) {
		$description = substr($post['name'],0,50) . "...";
	} else {
		$description = $post['name'];
	}
	echo "<li><a href=\"" . $url_base . "home/view/$post[id]\">$description</a>\r\n</li>"; 
}?>
</ul>
</div>

<div id="homecontainer">
<h1>Select a category to begin</h1>
<p class="info">The Campus Bullet v1.1 Beta. (C)2010 Dustin Masters.<br />
Please report ANY bugs with the system, and make suggestions as well using the same tool :)</p>
<div id="categories">
<? foreach($categories as $category) { ?>
<a class="button" href="<?=$url_base?>home/category/<?=$category['name']?>">
<img src="<?=$url_base?>images/<?=$category['name']?>.png" alt="" /><br />
<?=$category['prettyname']?>
</a>
<? } ?>
</div>

</div>