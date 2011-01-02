<h1><?=$category_prettyname?></h1>

<? if ($dategroups) { ?>
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


<? } else { ?>
<p>Sorry, I couldn't find any posts in this category.&nbsp; You should <a href="<?=$url_base?>post/new/<?=$category_name?>">post something</a>!</p>
<ul>
<li><a href="<?=$url_base?>">Go back home</a></li>
</ul>
<? } ?>


<div id="hp_sidebar">
<span class="hp_sidebar_title">About this category</span>
<p><?=$category_description?></p>
</div>
