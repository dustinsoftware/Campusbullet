<h1>Search results</h1>
<form action="" method="get">
<p>Search for:&nbsp; <input type="textbox" name="q" /> <input type="submit" value="Search!"/></p>
</form>

<? if ($posts) { ?>
<ul>
<? foreach($posts as $post) { 
	if ($post['wanted'])
		echo "<li>Wanted: <a href=\"" . $url_base . "home/view/$post[id]\">$post[title]</a></li>\r\n";
	else
		echo "<li><a href=\"" . $url_base . "home/view/$post[id]\">$post[title]</a></li>\r\n";
} ?>
</ul>


<? } else { ?>
<p>No posts were found for <?=$query?>.</p>
<? } ?>