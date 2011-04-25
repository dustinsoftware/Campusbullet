<h1>Search results</h1>

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
<p>No posts were found for <?=$query?>.&nbsp; Right now the search engine is pretty picky, so try using less words.&nbsp;
If nothing comes up, we don't have anything that matches.&nbsp; Sorry!</p>
<p><a href="<?=$url_base?>">Go back home?</a></p>
<? } ?>