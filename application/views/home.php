<div id="newposts">
<h1><a href="<?=$url_base?>home/category/all">Newest Posts</a></h1>
<? 
if ($newposts): ?>
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
<? else: ?>
<p>No posts found.</p>
<? endif; ?>

<h1><a href="<?=$url_base?>home/category/all?wanted">Wanted Stuff</a></h1>
<? if ($wantedposts): ?>
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
<? else: ?>
	<p>No posts found.</p>
<? endif; ?>
<br />
<iframe src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FThe-Campus-Bullet%2F184454954911265&amp;width=200&amp;colorscheme=light&amp;show_faces=false&amp;stream=false&amp;header=false&amp;height=72" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:72px; margin-left: 20px; background: white;" allowTransparency="true"></iframe>
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