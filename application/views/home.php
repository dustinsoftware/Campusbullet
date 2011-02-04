<div id="newposts">
<h1><a href="<?=$url_base?>home/category/all">Newest Posts</a></h1>
<ul>
<? foreach ($newposts as $post) { 
	if (strlen($post['name']) > 50) {
		$description = substr($post['name'],0,50) . "...";
	} else {
		$description = $post['name'];
	}
	if ($post['price'] > 0)
		$price = "$" . $post['price'];
	else
		$price = "FREE!";
	echo "<li><a href=\"" . $url_base . "home/view/$post[id]\">$description ($price)</a>\r\n</li>"; 
}?>
</ul>
<h1><a href="<?=$url_base?>home/category/all?wanted">Wanted Stuff</a></h1>
<ul>
<? foreach ($wantedposts as $post) { 
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
<div id="categories">
<? foreach($categories as $category) { ?>
<div class="buttonshadow">
<div class="button">
<a href="<?=$url_base?>home/category/<?=$category['name']?>">
<img width="150" height="150" src="<?=$url_base?>images/<?=$category['name']?>.png" alt="<?=$category['name']?>" /><br />
<?=$category['prettyname']?>
</a>
</div>
</div>
<? } ?>
</div>

</div>