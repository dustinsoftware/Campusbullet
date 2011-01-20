<h1><? if ($wanted) echo "Wanted "; ?><?=$category_prettyname?></h1>
<? if ($wanted) { ?>
<p class="info">You are viewing wanted items.&nbsp; <a href="<?=$url_base?>home/category/<?=$category_name?>">Click here to view posted items.</a></p>
<? } else { ?>
<p class="info">You are viewing posted items.&nbsp; <a href="<?=$url_base?>home/category/<?=$category_name?>?wanted">Click here to view wanted items.</a></p>
<? } ?>



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

<? if ($dategroups) { ?>

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