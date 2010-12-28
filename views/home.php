<h2>Home Page!</h2>

<div id="hp_posts">
<p>Posts, sorted by date, are shown below.</p>
<table style="width:100%">
<? foreach ($dategroups as $date => $posts) {
	echo ("<div class=\"dateheader\">$date</div>\n");
	
	echo ("<ul>");
	//spit out the date, then the posts in that group
	foreach ($posts as $post) {		
		echo ("<li><a href=\"$postbase$post[id]\">$post[title]</a></li>");				
	}
	echo ("</ul>");
} ?>
</table>
</div>

<div id="pagination"><?=$pagination ?></div>

<div id="hp_sidebar">
</div>