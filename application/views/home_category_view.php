<h1><?=$category_prettyname?></h1>


<div id="sidebar">
	<div id="sidebar_inner">
		<p class="sidebar_header">About this category</p>
		<div style="text-align:center;">
			<? if ($wanted) { ?>
			<img src="<?=$url_base?>images/wanted.png" alt="wanted <?=$category_name?>" />
			<? } else { ?>
			<img src="<?=$url_base?>images/<?=$category_name?>.png" alt="<?=$category_name?>" />
			<? } ?>
			
		</div>
		<p><?=$category_description?></p>
		<p style="text-align: center"><a href="<?=$url_base?>post/new/<?=$category_name?><? if ($wanted) echo "?wanted"; ?>">Post something here</a></p>
	</div>
</div>


<div id="hp_posts">
<div id="viewbuttons">
<a class="categorybutton <? if ( ! $wanted) echo "selected"; ?>" href="<?=$url_base?>home/category/<?=$category_name?>">posted</a>
<a class="categorybutton <? if ($wanted) echo "selected"; ?>" href="<?=$url_base?>home/category/<?=$category_name?>?wanted">wanted</a>
<a class="createbutton" href="<?=$url_base?>post/new/<?=$category_name?><? if ($wanted) echo "?wanted"; ?>">create post</a>
<div style="clear:left"></div>
</div>

<? if ($dategroups) { ?>

<p>Posts, sorted by date, are shown below.</p>
<table style="width:100%">
<? foreach ($dategroups as $date => $posts) {
	echo ("<div class=\"dateheader\">$date</div>\n");
	
	echo ("<ul>");
	//spit out the date, then the posts in that group
	foreach ($posts as $post) {		
		if ($post['image'])
			$image =  " <img src=\"{$url_base}images/pictures.png\" alt=\"\" />";
		else
			$image = null;
		echo ("<li><a href=\"$postbase$post[id]\">$post[title]</a>$image</li>");				
	}
	echo ("</ul>");
} ?>
</table>


<div id="pagination"><?= $pagination?></div>

<? } else { ?>
<p>Sorry, I couldn't find any posts in this category.&nbsp; You should post something!</p>
<? } ?>

<p>What would you like to do?</p>
<ul>
<li><a href="<?=$url_base?>post/new/<?=$category_name?><? if ($wanted) echo "?wanted"; ?>">Post something to this category</a>
<li><a href="<?=$url_base?>">Go back home</a></li>
</ul>

</div>