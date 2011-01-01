<h1>Search results</h1>
<form action="" method="get">
<p>Search term:&nbsp; <input type="textbox" name="q" /> <input type="submit" value="Search!"/></p>
</form>

<? if ($posts) { ?>
<ul>
<? foreach($posts as $post) { 
	echo "<li><a href=\"" . $url_base . "home/view/$post[id]\">$post[name]</a></li>\r\n";
} ?>
</ul>


<? } else { ?>
<p>No posts were found for <?=$query?>.</p>
<? } ?>