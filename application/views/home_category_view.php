<h1><?=$category_prettyname?></h1>

<div id="sidebar">
<div id="sidebar_inner">
<p class="sidebar_header">About this category</p>
<p><?=$category_description?></p>
<p style="text-align: center"><a href="<?=$url_base?>post/new/<?=$category_name?>">Post something here</a></p>
</div>
</div>

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

<div id="pagination"><?= $pagination?></div>

<? } else { ?>
<p>Sorry, I couldn't find any posts in this category.&nbsp; You should post something!</p>
<? } ?>

<p>What would you like to do?</p>
<ul>
<li><a href="<?=$url_base?>post/new/<?=$category_name?>">Post something to this category</a>
<li><a href="<?=$url_base?>">Go back home</a></li>
</ul>
